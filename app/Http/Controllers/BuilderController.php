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
use App\Services\BuilderService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class BuilderController extends Controller
{
    protected $errorService;
    protected $builderService;

    
    public function __construct(ErrorService $errorService, BuilderService $builderService)
    {
        $this->errorService = $errorService;
        $this->builderService = $builderService;
    }


    public function getMyBuildsPage() {
        try {
            $builds = $this->builderService->getUserBuilds();

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
            $this->builderService->createNewBuild($requestData);

            return response()->json([], 200);
        }
        catch(Exception $e) {
            return $this->errorService->handleExceptionJSON($e);
        }
    }


    public function getBuild($encodedBuildId) {
        try {
            $build = Build::findOrFail(EncodeHelper::decode($encodedBuildId));

            $this->builderService->checkPermissionToViewBuild($build);

            //Get an array of arrays(represents the build component) of buy link ids
            $eachBuildComponentBuyLinkIds = $this->builderService->getEachBuildComponentBuyLinkIds($build->id);
            //Get every possible combination of the buy link ids for each component from the array of arrays
            //where every array represents a component and inside it its buy link ids
            $buildComponentsBuyLinkIdsCombinations = $this->builderService->getAllCombinationsOfArrayOfArrays($eachBuildComponentBuyLinkIds);
            //Get the cheapest combination of buy links
            $cheapestBuildComponentsBuyLinksCombination = collect($this->builderService->getCheapestBuyLinksCombination($buildComponentsBuyLinkIdsCombinations));

            $buildTotals = $this->builderService->calculateBuyLinksCombinationTotals($cheapestBuildComponentsBuyLinksCombination);
            $buildComponents = BuildComponent::where('build_id', $build->id)->get();

            return view('build', compact('build', 'buildComponents', 'buildTotals', 'cheapestBuildComponentsBuyLinksCombination'));
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
            $buildComponentTypeId = $request->query('build-component-type-id');

            $build = Build::findOrFail(EncodeHelper::decode($encodedBuildId));

            $this->builderService->checkIsUserBuildOwner($build);

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

            $this->builderService->checkIsUserBuildOwnerJSON($build);

            //Create the build component
            $buildComponent = $this->builderService->createBuildComponent($requestData);

            //Create the buy links for the build component
            $this->builderService->createBuyLinks($requestData, $buildComponent);

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

        if($requestData['deliveryGroupDeliveryCost']) {
            $deliveryGroupCost = $requestData['deliveryGroupDeliveryCost'];
        }

        try {
            $build = Build::findOrFail($requestData['deliveryGroupBuildId']);

            $this->builderService->checkIsUserBuildOwnerJSON($build);

            $this->builderService->createDeliveryGroup($requestData, $deliveryGroupCost, $build);

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

            $this->builderService->checkIsUserBuildOwnerJSON($buildComponentToDelete->build);

            $buildComponentToDelete->delete();

            return response()->json([], 200);
        }
        catch(Exception $e) {
            $this->errorService->handleExceptionJSON($e);
        }
    }


    public function getBuildComponentPage($encodedBuildComponentId) {
        try {
            $buildComponent = BuildComponent::findOrFail(EncodeHelper::decode($encodedBuildComponentId));

            $this->builderService->checkPermissionToViewBuildJSON($buildComponent->build);

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

            $this->builderService->checkIsUserBuildOwnerJSON($buildComponent->build);

            //If the build component name is changed save it in the DB
            if($buildComponent->name != $requestData['buildComponentName']) {
                $buildComponent->name = $requestData['buildComponentName'];
                $buildComponent->save();
            }

            //Apply the changes to existing build component buy links
            $this->builderService->updateBuyLinks($requestData);

            //Delete the buy links from the DB that were deleted client side
            $this->builderService->deleteFromDbDeletedClientSideBuyLinks($requestData, $buildComponent);

            //Create the new buy links for the build component
            $this->builderService->createBuyLinks($requestData, $buildComponent);

            DB::commit();
            return response()->json([], 200);
        }
        catch(Exception $e) {
            DB::rollBack();
            $this->errorService->handleExceptionJSON($e);
        }
    }


    public function deleteBuild($encodedBuildId) {
        try {
            $build = Build::findOrFail(EncodeHelper::decode($encodedBuildId));

            $this->builderService->checkIsUserBuildOwnerJSON($build);

            $build->delete();

            return response()->json([], 200);
        }
        catch(Exception $e) {
            $this->errorService->handleExceptionJSON($e);
        }
    }


    public function saveBuildName(Request $request) {
        $requestData = $request->validate([
            'buildId' => ['required', 'int'],
            'newBuildName' => ['required', 'max:30'],
        ],
        [
            'buildId.required' => __('errors.save_build_name.build_id_required'),
            'buildId.int' => __('errors.save_build_name.build_id_int'),
            'newBuildName.required' => __('errors.save_build_name.new_build_name_required'),
            'newBuildName.max' => __('errors.save_build_name.new_build_name_max'),
        ]);

        try {
            $build = Build::findOrFail($requestData['buildId']);
            $build->name = $requestData['newBuildName'];
            $build->save();

            return response()->json([], 200);
        }
        catch(Exception $e) {
            $this->errorService->handleExceptionJSON($e);
        }
    }


    public function manageDeliveryGroups(Request $request) {
        $encodedBuildId = $request->query('build');

        try {
            $build = Build::findOrFail(EncodeHelper::decode($encodedBuildId));

            $buildDeliveryGroups = DeliveryGroup::where('build_id', $build->id)->get();

            return view('manage_build_delivery_groups', compact('build', 'buildDeliveryGroups'));
        }
        catch(Exception $e) {
            $this->errorService->handleException($e);
        }
    }


    public function getBuildsPage() {
        return view('builds');
    }


    public function getDiscussionsPage() {
        return view('discussions');
    }
}