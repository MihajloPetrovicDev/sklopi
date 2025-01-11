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
use Illuminate\Support\Facades\DB;
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
        $requestData = $request->validate([
            'buildName' => ['max: 30'],
            'buildVisibility' => ['required', 'boolean'],
        ],
        [
            'buildName.max' => __('errors.create_new_build.build_name_max'),
            'buildVisibility.required' => __('errors.create_new_build.build_visibility_reqired'),
            'buildVisibility.boolean' => __('errors.create_new_build.build_visibility_boolean'),
        ]);

        try {
            if(!$requestData['buildName']) {
                $buildName = __('default_values.build_default_name');
            }
            else {
                $buildName = $requestData['buildName'];
            }

            $build = new Build();

            $build->user_id = Auth::id();
            $build->name = $buildName;
            $build->is_public = $requestData['buildVisibility'];
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
                abort(403);
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

            if($build->user_id != Auth::id()) {
                abort(403);
            }

            return view('add_build_component', compact('build', 'buildComponentTypeId'));
        }
        catch(Exception $e) {
            $this->errorService->handleException($e);
        }
    }


    public function getBuildDeliveryGroups(Request $request) {
        $requestData = $request->validate([
            'buildId' => ['required', 'int']
        ],
        [
            'buildId.required' => __('errors.get_build_delivery_groups.build_id_required'),
            'buildId.int' => __('errors.get_build_delivery_groups.build_id_int'),
        ]);

        try {
            $deliveryGroups = DeliveryGroup::where('user_id', Auth::id())
                ->where(function ($query) use ($requestData) {
                    $query->where('build_id', null)
                        ->orWhere('build_id', $requestData['buildId']);
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
        $requestData = $request->validate([
            'buildComponentName' => ['required', 'max: 200'],
            'buildComponentTypeId' => ['required', 'int', 'min: 1', 'max: 8'],
            'buildComponentBuildId' => ['required', 'int'],
            //Add buy links
            'buildComponentAddBuyLinks' => ['nullable', 'array'],
            'buildComponentAddBuyLinks.*.name' => ['nullable', 'max:50'],
            'buildComponentAddBuyLinks.*.link' => ['required', 'max:300'],
            'buildComponentAddBuyLinks.*.price' => ['nullable', 'numeric', 'min:0'],
            'buildComponentAddBuyLinks.*.deliveryGroupId' => ['nullable', 'int'],
        ],
        [
            'buildComponentName.required' => __('errors.add_new_build_component.build_component_name_required'),
            'buildComponentName.max' => __('errors.add_new_build_component.build_component_name_max'),
            'buildComponentTypeId.required' => __('errors.add_new_build_component.build_component_type_id_required'),
            'buildComponentTypeId.int' => __('errors.add_new_build_component.build_component_type_id_int'),
            'buildComponentTypeId.min' => __('errors.add_new_build_component.build_component_type_id_min'),
            'buildComponentTypeId.max' => __('errors.add_new_build_component.build_component_type_id_max'),
            'buildComponentBuildId.required' => __('errors.add_new_build_component.build_component_build_id_required'),
            'buildComponentBuildId.int' => __('errors.add_new_build_component.build_component_build_id_int'),
            //Add buy links
            'buildComponentAddBuyLinks.array' => __('errors.add_new_build_component.build_component_add_buy_links_array'),
            'buildComponentAddBuyLinks.*.name.max' => __('errors.add_new_build_component.build_component_add_buy_links_*_name_max'),
            'buildComponentAddBuyLinks.*.link.required' => __('errors.add_new_build_component.build_component_add_buy_links_*_link_required'),
            'buildComponentAddBuyLinks.*.link.max' => __('errors.add_new_build_component.build_component_add_buy_links_*_link_max'),
            'buildComponentAddBuyLinks.*.price.numeric' => __('errors.add_new_build_component.build_component_add_buy_links_*_price_numeric'),
            'buildComponentAddBuyLinks.*.price.min' => __('errors.add_new_build_component.build_component_add_buy_links_*_price_min'),
            'buildComponentAddBuyLinks.*.deliveryGroupId.int' => __('errors.add_new_build_component.build_component_add_buy_links_*_delivery_group_id_int'),

        ]);

        DB::beginTransaction();

        try {
            $build = Build::findOrFail($requestData['buildComponentBuildId']);

            if($build->user_id != Auth::id()) {
                return response()->json([], 403);
            }

            //Create the build component
            $buildComponent = new BuildComponent();

            $buildComponent->name = $requestData['buildComponentName'];
            $buildComponent->type_id = $requestData['buildComponentTypeId'];
            $buildComponent->build_id = $requestData['buildComponentBuildId'];

            $buildComponent->save();

            //Create the buy links for the build component
            foreach($requestData['buildComponentAddBuyLinks'] as $addBuyLinksArrayItem) {
                $addBuyLinkName = __('default_values.buy_link_default_name');

                if($addBuyLinksArrayItem['name'] != '') {
                    $addBuyLinkName = $addBuyLinksArrayItem['name'];
                }

                $buildComponentAddBuyLink = new BuyLink();
                
                $buildComponentAddBuyLink->name = $addBuyLinkName;
                $buildComponentAddBuyLink->link = $addBuyLinksArrayItem['link'];
                $buildComponentAddBuyLink->price = $addBuyLinksArrayItem['price'];
                $buildComponentAddBuyLink->build_component_id = $buildComponent->id;

                if($addBuyLinksArrayItem['deliveryGroupId'] != null) {
                    $buildComponentAddBuyLink->delivery_group_id = $addBuyLinksArrayItem['deliveryGroupId'];
                }

                $buildComponentAddBuyLink->save();
            }

            DB::commit();
            return response()->json([], 201);
        } 
        catch(Exception $e) {
            DB::rollBack();
            $this->errorService->handleExceptionJSON($e);
        }
    }


    public function createNewDeliveryGroup(Request $request) {
        $requestData = $request-> validate([
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

        if($requestData['deliveryGroupDeliveryCost']) {
            $deliveryGroupCost = $requestData['deliveryGroupDeliveryCost'];
        }

        try {
            $build = Build::findOrFail($requestData['deliveryGroupBuildId']);

            if($build->user_id != $userId) {
                return response()->json([], 403);
            }

            $deliveryGroup = new DeliveryGroup();

            $deliveryGroup->name = $requestData['deliveryGroupName'];
            $deliveryGroup->user_id = $userId;
            $deliveryGroup->free_delivery_at = $requestData['deliveryGroupFreeDeliveryAt'];
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
        $requestData = $request->validate([
            'deleteBuildComponentId' => ['required', 'int'],
        ],
        [
            'deleteBuildComponentId.required' => __('errors.delete_build_component.delete_build_component_id_required'),
            'deleteBuildComponentId.int' => __('errors.delete_build_component.delete_build_component_id_int'),
        ]);

        try {
            $buildComponentToDelete = BuildComponent::findOrFail($requestData['deleteBuildComponentId']);

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


    public function updateBuildComponent(Request $request) {
        $requestData = $request->validate([
            'buildComponentId' => ['required', 'int'],
            'buildComponentName' => ['required', 'max:200'],
            //Buy Links
            'buildComponentBuyLinks' => ['nullable', 'array'],
            'buildComponentBuyLinks.*.id' => ['required', 'int'],
            'buildComponentBuyLinks.*.name' => ['required', 'max:50'],
            'buildComponentBuyLinks.*.link' => ['required', 'max:300'],
            'buildComponentBuyLinks.*.price' => ['required', 'numeric', 'min:0'],
            'buildComponentBuyLinks.*.deliveryGroupId' => ['nullable', 'int'],
            //Add Buy Links
            'buildComponentAddBuyLinks' => ['nullable', 'array'],
            'buildComponentAddBuyLinks.*.name' => ['nullable', 'max:50'],
            'buildComponentAddBuyLinks.*.link' => ['required', 'max:300'],
            'buildComponentAddBuyLinks.*.price' => ['nullable', 'numeric', 'min:0'],
            'buildComponentAddBuyLinks.*.deliveryGroupId' => ['nullable', 'int'],
        ],
        [
            'buildComponentId.required' => __('errors.update_build_component.build_component_id_required'),
            'buildComponentId.int' => __('errors.update_build_component.build_component_id_int'),
            'buildComponentName.required' => __('errors.update_build_component.build_component_name_required'),
            'buildComponentName.max' => __('errors.update_build_component.build_component_name_max'),
            //Buy Links
            'buildComponentBuyLinks.array' => __('errors.update_build_component.build_component_buy_links_array'),
            'buildComponentBuyLinks.*.id.required' => __('errors.update_build_component.build_component_buy_links_*_id_required'),
            'buildComponentBuyLinks.*.id.int' => __('errors.update_build_component.build_component_buy_links_*_id_int'),
            'buildComponentBuyLinks.*.name.required' => __('errors.update_build_component.build_component_buy_links_*_name_required'),
            'buildComponentBuyLinks.*.name.max' => __('errors.update_build_component.build_component_buy_links_*_name_max'),
            'buildComponentBuyLinks.*.link.required' => __('errors.update_build_component.build_component_buy_links_*_link_required'),
            'buildComponentBuyLinks.*.link.max' => __('errors.update_build_component.build_component_buy_links_*_link_max'),
            'buildComponentBuyLinks.*.price.required' => __('errors.update_build_component.build_component_buy_links_*_price_required'),
            'buildComponentBuyLinks.*.price.numeric' => __('errors.update_build_component.build_component_buy_links_*_price_numeric'),
            'buildComponentBuyLinks.*.price.min' => __('errors.update_build_component.build_component_buy_links_*_price_min'),
            'buildComponentBuyLinks.*.deliveryGroupId.int' => __('errors.update_build_component.build_component_buy_links_*_delivery_group_id_int'),
            //Add Buy Links
            'buildComponentAddBuyLinks.array' => __('errors.update_build_component.build_component_add_buy_links_array'),
            'buildComponentAddBuyLinks.*.name.max' => __('errors.update_build_component.build_component_add_buy_links_*_name_max'),
            'buildComponentAddBuyLinks.*.link.required' => __('errors.update_build_component.build_component_add_buy_links_*_link_required'),
            'buildComponentAddBuyLinks.*.link.max' => __('errors.update_build_component.build_component_add_buy_links_*_link_max'),
            'buildComponentAddBuyLinks.*.price.numeric' => __('errors.update_build_component.build_component_add_buy_links_*_price_numeric'),
            'buildComponentAddBuyLinks.*.price.min' => __('errors.update_build_component.build_component_add_buy_links_*_price_min'),
            'buildComponentAddBuyLinks.*.deliveryGroupId.int' => __('errors.update_build_component.build_component_add_buy_links_*_delivery_group_id_int'),
        ]);

        DB::beginTransaction();

        try {
            $buildComponent = BuildComponent::findOrFail($requestData['buildComponentId']);

            if($buildComponent->build->user_id != Auth::id()) {
                return response()->json([], 403);
            }

            //If the build component name is changed save it in the DB
            if($buildComponent->name != $requestData['buildComponentName']) {
                $buildComponent->name = $requestData['buildComponentName'];

                $buildComponent->save();
            }

            //Apply the changes to existing build component buy links
            foreach($requestData['buildComponentBuyLinks'] as $buyLinksArrayItem) {
                $buildComponentBuyLink = BuyLink::findOrFail($buyLinksArrayItem['id']);

                if($buildComponentBuyLink->name != $buyLinksArrayItem['name']) {
                    $buildComponentBuyLink->name = $buyLinksArrayItem['name'];
                }

                if($buildComponentBuyLink->link != $buyLinksArrayItem['link']) {
                    $buildComponentBuyLink->link = $buyLinksArrayItem['link'];
                }

                if($buildComponentBuyLink->price != $buyLinksArrayItem['price']) {
                    $buildComponentBuyLink->price = $buyLinksArrayItem['price'];
                }

                if($buildComponentBuyLink->delivery_group_id != $buyLinksArrayItem['deliveryGroupId']) {
                    if($buyLinksArrayItem['deliveryGroupId'] != null) {
                        $newDeliveryGroup = DeliveryGroup::findOrFail($buyLinksArrayItem['deliveryGroupId']);

                        $buildComponentBuyLink->delivery_group_id = $newDeliveryGroup->id;
                    }
                    else {
                        $buildComponentBuyLink->delivery_group_id = null;
                    }
                }

                $buildComponentBuyLink->save();
            }

            //Delete the buy links from the DB that were deleted client side
            $buildComponentDbBuyLinksArray = BuyLink::where('build_component_id', $buildComponent->id)->pluck('id')->toArray();
            $buildComponentRequestBuyLinksArray = collect($requestData['buildComponentBuyLinks'])->pluck('id')->toArray();

            $buildComponentBuyLinksToDelete = array_diff($buildComponentDbBuyLinksArray, $buildComponentRequestBuyLinksArray);

            if(!empty($buildComponentBuyLinksToDelete)) {
                BuyLink::whereIn('id', $buildComponentBuyLinksToDelete)->delete();
            }

            //Create the new buy links for the build component
            foreach($requestData['buildComponentAddBuyLinks'] as $addBuyLinksArrayItem) {
                $buildComponentAddBuyLinkName = __('default_values.buy_link_default_name');

                if($addBuyLinksArrayItem['name'] != '') {
                    $buildComponentAddBuyLinkName = $addBuyLinksArrayItem['name'];
                }

                $buildComponentAddBuyLink = new BuyLink();
                
                $buildComponentAddBuyLink->name = $buildComponentAddBuyLinkName;
                $buildComponentAddBuyLink->link = $addBuyLinksArrayItem['link'];
                $buildComponentAddBuyLink->price = $addBuyLinksArrayItem['price'];
                $buildComponentAddBuyLink->build_component_id = $buildComponent->id;

                if($addBuyLinksArrayItem['deliveryGroupId'] != null) {
                    $buildComponentAddBuyLink->delivery_group_id = $addBuyLinksArrayItem['deliveryGroupId'];
                }

                $buildComponentAddBuyLink->save();
            }

            DB::commit();
            return response()->json([], 200);
        }
        catch(Exception $e) {
            DB::rollBack();
            $this->errorService->handleExceptionJSON($e);
        }
    }
}