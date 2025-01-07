<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Build;
use App\Models\BuyLink;
use Illuminate\Http\Request;
use App\Helpers\EncodeHelper;
use App\Models\DeliveryGroup;
use App\Models\BuildComponent;
use App\Services\ErrorService;
use Illuminate\Support\Facades\Auth;

class BuilderController extends Controller
{
    protected $errorService;

    
    public function __construct(ErrorService $errorService)
    {
        $this->errorService = $errorService;
    }


    public function getMyBuildsPage() {
        try {
            $builds = collect();

            if(Auth::check()) {
                $builds = Build::where('user_id', Auth::id())->get();
            }

            return view('my_builds', compact('builds'));
        }
        catch(Exception $e) {
            return $this->errorService->handleException($e);
        }
    }


    public function getCreateNewBuildPage() {
        return view('create_new_build');
    }


    public function createNewBuild(Request $request) {
        $incomingFields = $request->validate([
            'buildName' => ['max: 30'],
            'buildVisibility' => ['required', 'boolean'],
        ],
        [
            'buildName.max' => __('errors.create_new_build.build_name_max'),
            'buildVisibility.required' => __('errors.create_new_build.build_visibility_reqired'),
            'buildVisibility.boolean' => __('errors.create_new_build.build_visibility_boolean'),
        ]);

        try {
            if(!$incomingFields['buildName']) {
                $buildName = __('ui.create_new_build.build');
            }
            else {
                $buildName = $incomingFields['buildName'];
            }

            $build = new Build();

            $build->user_id = Auth::id();
            $build->name = $buildName;
            $build->is_public = $incomingFields['buildVisibility'];
            $build->country_id = 1;
            $build->currency = 'RSD';

            $build->save();

            return response()->json([], 200);
        }
        catch(Exception $e) {
            return $this->errorService->handleExceptionJSON($e);
        }
    }


    public function getBuild($encodedBuildId) {
        try {
            $buildId = EncodeHelper::decode($encodedBuildId);

            $build = Build::findOrFail($buildId);

            if($build->user_id != Auth::id() && $build->is_public == false) {
                return response()->json([], 403);
            }

            $buildComponents = BuildComponent::where('build_id', $build->id)->get();

            return view('build', compact('build', 'buildComponents'));
        }
        catch(Exception $e) {
            $this->errorService->handleException($e);
        }
    }


    public function getGuestBuild() {
        return view('guest_build');
    }


    public function getAddBuildComponent(Request $request) {
        try {
            $encodedBuildId = $request->query('build-id');
            $buildId = EncodeHelper::decode($encodedBuildId);
            $buildComponentTypeId = $request->query('build-component-type-id');

            $build = Build::findOrFail($buildId);

            return view('add_build_component', compact('build', 'buildComponentTypeId', 'encodedBuildId'));
        }
        catch(Exception $e) {
            $this->errorService->handleException($e);
        }
    }


    public function getBuildDeliveryGroups(Request $request) {
        $incomingFields = $request->validate([
            'buildId' => ['required', 'int']
        ], [
            'buildId.required' => __('errors.get_build_delivery_groups.build_id_required'),
            'buildId.int' => __('errors.get_build_delivery_groups.build_id_int'),
        ]);

        try {
            $deliveryGroups = DeliveryGroup::where('user_id', Auth::id())
                ->where(function ($query) use ($incomingFields) {
                    $query->where('build_id', null)
                        ->orWhere('build_id', $incomingFields['buildId']);
                })
                ->get()
                ->toArray();
            
            return response()->json(['deliveryGroups' => $deliveryGroups], 200);
        }
        catch(Exception $e) {
            $this->errorService->handleExceptionJSON($e);
        }
    }


    public function addNewBuildComponent(Request $request) {
        $incomingFields = $request->validate([
            'buildComponentName' => ['required', 'max: 200'],
            'buildComponentTypeId' => ['required', 'int', 'min: 1', 'max: 8'],
            'buildComponentBuildId' => ['required', 'int'],
            'buildComponentBuyLinks' => ['nullable'],
        ], [
            'buildComponentName.required' => __('errors.add_new_build_component.build_component_name_required'),
            'buildComponentName.max' => __('errors.add_new_build_component.build_component_name_max'),
            'buildComponentTypeId.required' => __('errors.add_new_build_component.build_component_type_id_required'),
            'buildComponentTypeId.int' => __('errors.add_new_build_component.build_component_type_id_int'),
            'buildComponentTypeId.min' => __('errors.add_new_build_component.build_component_type_id_min'),
            'buildComponentTypeId.max' => __('errors.add_new_build_component.build_component_type_id_max'),
            'buildComponentBuildId.required' => __('errors.add_new_build_component.build_component_build_id_required'),
            'buildComponentBuildId.int' => __('errors.add_new_build_component.build_component_build_id_int'),
        ]);

        try {
            $build = Build::findOrFail($incomingFields['buildComponentBuildId']);

            if($build->user_id != Auth::id()) {
                return response()->json([], 403);
            }

            //Create the build component
            $buildComponent = new BuildComponent();

            $buildComponent->name = $incomingFields['buildComponentName'];
            $buildComponent->type_id = $incomingFields['buildComponentTypeId'];
            $buildComponent->build_id = $incomingFields['buildComponentBuildId'];

            $buildComponent->save();

            //Create the buy links for the build component
            foreach($incomingFields['buildComponentBuyLinks'] as $buyLinksArrayItem) {
                $buyLinkName = __('ui.add_build_component.buy_link_default_name');

                if($buyLinksArrayItem['name'] != '') {
                    $buyLinkName = $buyLinksArrayItem['name'];
                }

                $buyLink = new BuyLink();
                
                $buyLink->name = $buyLinkName;
                $buyLink->link = $buyLinksArrayItem['link'];
                $buyLink->price = $buyLinksArrayItem['price'];
                $buyLink->build_component_id = $buildComponent->id;

                if($buyLinksArrayItem['deliveryGroupId'] != 'null') {
                    $buyLink->delivery_group_id = $buyLinksArrayItem['deliveryGroupId'];
                }

                $buyLink->save();
            }

            return response()->json([], 201);
        } 
        catch(Exception $e) {
            $this->errorService->handleExceptionJSON($e);
        }
    }


    public function createNewDeliveryGroup(Request $request) {
        $incomingFields = $request-> validate([
            'deliveryGroupName' => ['required', 'max:50'],
            'deliveryGroupFreeDeliveryAt' => ['nullable'],
            'deliveryGroupDeliveryCost' => ['nullable'],
            'deliveryGroupBuildId' => ['required', 'int'],
        ],
        [
            'deliveryGroupName.required' => __('errors.create_new_delivery_group.delivery_group_name_required'),
            'deliveryGroupName.max' => __('errors.create_new_delivery_group.delivery_group_name_max'),
            'deliveryGroupBuildId.required' => __('errors.create_new_delivery_group.build_id_required'),
            'deliveryGroupBuildId.int' => __('errors.create_new_delivery_group.build_id_int'),
        ]);

        $deliveryGroupCost = 0;
        $userId = Auth::id();

        if($incomingFields['deliveryGroupDeliveryCost']) {
            $deliveryGroupCost = $incomingFields['deliveryGroupDeliveryCost'];
        }

        try {
            $build = Build::findOrFail($incomingFields['deliveryGroupBuildId']);

            if($build->user_id != $userId) {
                return response()->json([], 403);
            }

            $deliveryGroup = new DeliveryGroup();

            $deliveryGroup->name = $incomingFields['deliveryGroupName'];
            $deliveryGroup->user_id = $userId;
            $deliveryGroup->free_delivery_at = $incomingFields['deliveryGroupFreeDeliveryAt'];
            $deliveryGroup->delivery_cost = $deliveryGroupCost;
            $deliveryGroup->build_id = $build->id;
            $deliveryGroup->currency = 'RSD';

            $deliveryGroup->save();

            return response()->json([], 201);
        }
        catch(Exception $e) {
            $this->errorService->handleExceptionJSON($e);
        }
    }


    public function deleteBuildComponent(Request $request) {
        $incomingFields = $request->validate([
            'deleteBuildComponentId' => ['required', 'int'],
        ],
        [
            'deleteBuildComponentId.required' => __('errors.delete_build_component.delete_build_component_id_required'),
            'deleteBuildComponentId.int' => __('errors.delete_build_component.delete_build_component_id_int'),
        ]);

        try {
            $buildComponentToDelete = BuildComponent::findOrFail($incomingFields['deleteBuildComponentId']);

            if($buildComponentToDelete->build->user_id != Auth::id()) {
                return response()->json([], 403);
            }

            $buildComponentToDelete->delete();

            return response()->json([], 200);
        }
        catch(Exception $e) {
            $this->errorService->handleExceptionJSON($e);
        }
    }


    public function getBuildComponentPage($encodedBuildComponentId) {
        try {
            $buildComponentId = EncodeHelper::decode($encodedBuildComponentId);

            $buildComponent = BuildComponent::findOrFail($buildComponentId);

            if($buildComponent->build->user_id != Auth::id() && $buildComponent->build->is_public == false) {
                return response()->json([], 403);
            }

            $buildDeliveryGroups = DeliveryGroup::where('user_id', Auth::id())
                ->where(function ($query) use ($buildComponent) {
                    $query->where('build_id', null)
                        ->orWhere('build_id', $buildComponent->build_id);
                })
                ->get();

            return view('build_component', compact('buildComponent', 'buildDeliveryGroups'));
         }
        catch(Exception $e) {
            $this->errorService->handleExceptionJSON($e);
        }
    }
}