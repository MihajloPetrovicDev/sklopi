<?php

namespace App\Services;

use App\Models\Build;
use App\Models\BuyLink;
use App\Models\DeliveryGroup;
use App\Models\BuildComponent;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class BuilderService {
    public function getEachBuildComponentBuyLinkIds($buildId) {
        $build = Build::findOrFail($buildId);
        $buildComponents = BuildComponent::where('build_id', $build->id)->get();
        $buyLinkIdsArray = [];

        foreach($buildComponents as $buildComponent) {
            $buyLinks = [];

            foreach($buildComponent->buyLinks as $buyLink) {
                array_push($buyLinks, $buyLink->id);
            }

            array_push($buyLinkIdsArray, $buyLinks);
        }

        return $buyLinkIdsArray;
    }


    public function getAllCombinationsOfArrayOfArrays($arrayOfArrays) {
        $result = [[]];

        foreach($arrayOfArrays as $array) {
            if(empty($array)) {
                continue;
            }

            $newResult = [];

            foreach($result as $combination) {
                foreach($array as $item) {
                    $newResult[] = array_merge($combination, [$item]);
                }
            }

            $result = $newResult;
        }

        return $result;
    }


    public function getCheapestBuyLinksCombination($buyLinkIdsCombinations) {
        $buyLinkCombinationTotalPrices = [];
        $buyLinksCombinations = [];

        //Iterate trough each buy link ids combination
        foreach($buyLinkIdsCombinations as $buyLinkIdsCombination) {
            $buyLinksCombination = $this->transformBuyLinkIdsArrayToBuyLinksArray($buyLinkIdsCombination);
            $buyLinksCombinationTotals = $this->calculateBuyLinksCombinationTotals($buyLinksCombination);

            array_push($buyLinkCombinationTotalPrices, $buyLinksCombinationTotals['combinationTotal']);
            array_push($buyLinksCombinations, $buyLinksCombination);
        }

        //Get the minimum value from the array of combination total prices, then search the array of combination total
        //prices with that value to find its index, then get the combination by accessing the combinations array with that index
        $minimumBuyLinksCombinationTotal = min($buyLinkCombinationTotalPrices);
        $minimumBuyLinksCombinationTotalIndex = array_search($minimumBuyLinksCombinationTotal, $buyLinkCombinationTotalPrices);
        $minimumTotalPriceBuyLinksCombination = $buyLinksCombinations[$minimumBuyLinksCombinationTotalIndex];

        return $minimumTotalPriceBuyLinksCombination;
    }


    public function transformBuyLinkIdsArrayToBuyLinksArray($buildComponentBuyLinkIdsArray) {
        $buildComponentBuyLinks = [];

        foreach($buildComponentBuyLinkIdsArray as $buildComponentBuyLinkId) {
            $buildComponentBuyLink = BuyLink::findOrFail($buildComponentBuyLinkId);

            array_push($buildComponentBuyLinks, $buildComponentBuyLink);
        }

        return $buildComponentBuyLinks;
    }


    public function calculateBuyLinksCombinationTotals($buyLinksCombination) {
        $combinationComponentTotal = 0;
        $combinationDeliveryTotal = 0;
        $combinationUsedDeliveryGroupIds = [];

        //For each buy link from the combination adjust the combinationComponentTotal and add
        //the delivery group id to the combinationUsedDeliveryGroups if it isn't added already
        foreach($buyLinksCombination as $buildComponentBuyLink) {
            $combinationComponentTotal += $buildComponentBuyLink->price;

            if(!in_array($buildComponentBuyLink->delivery_group_id, $combinationUsedDeliveryGroupIds) && $buildComponentBuyLink->delivery_group_id) {
                array_push($combinationUsedDeliveryGroupIds, $buildComponentBuyLink->delivery_group_id);
            }
        }

        //For each delivery group used in the combination, set the deliveryGroupDeliveryCost to the delivery
        //group delivery_cost and calculate the totalDeliveryGroupComponentsPrice of the delivery group
        //and if that passes the free_delivery_at treshold of the delivery group set the deliveryGroupDeliveryCost
        //of the delivery group to 0, then add to the deliveryGroupDeliveryCost the combinationDeliveryTotal
        foreach($combinationUsedDeliveryGroupIds as $combinationUsedDeliveryGroupId) {
            $combinationUsedDeliveryGroup = DeliveryGroup::findOrFail($combinationUsedDeliveryGroupId);
            $totalDeliveryGroupComponentsPrice = 0;
            $deliveryGroupDeliveryCost = $combinationUsedDeliveryGroup->delivery_cost;
            $deliveryGroupBuyLinks = BuyLink::where('delivery_group_id', $combinationUsedDeliveryGroup->id)->get();

            foreach($deliveryGroupBuyLinks as $deliveryGroupBuyLink) {
                $totalDeliveryGroupComponentsPrice += $deliveryGroupBuyLink->price;
            }

            if($totalDeliveryGroupComponentsPrice > $combinationUsedDeliveryGroup->free_delivery_at && $combinationUsedDeliveryGroup->free_delivery_at != null) {
                $deliveryGroupDeliveryCost = 0;
            }

            $combinationDeliveryTotal += $deliveryGroupDeliveryCost;
        }

        $combinationTotal = $combinationComponentTotal + $combinationDeliveryTotal;

        $combinationTotals = [
            'combinationComponentTotal' => $combinationComponentTotal,
            'combinationDeliveryTotal' => $combinationDeliveryTotal,
            'combinationTotal' => $combinationTotal
        ];

        return $combinationTotals;
    }


    public function getUserBuilds() {
        $builds = collect();

        if(Auth::check()) {
            $builds = Build::where('user_id', Auth::id())->get();
        }

        return $builds;
    }


    public function createNewBuild($requestData) {
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
    }


    public function checkPermissionToViewBuild($build) {
        if($build->user_id != Auth::id() && $build->is_public == false) {
            abort(403);
        }
    }


    public function checkPermissionToViewBuildJSON($build) {
        if($build->user_id != Auth::id() && $build->is_public == false) {
            return response()->json([], 403);
        }
    }


    public function checkIsUserBuildOwner($build) {
        if($build->user_id != Auth::id()) {
            abort(403);
        }
    }

    public function checkIsUserBuildOwnerJSON($build) {
        if($build->user_id != Auth::id()) {
            return response()->json([], 403);
        }
    }


    public function checkIsUserDeliveryGroupOwnerJSON($deliveryGroup) {
        if($deliveryGroup->user_id != Auth::id()) {
            return response()->json([], 403);
        }
    }


    public function createBuyLinks($requestData, $buildComponent) {
        foreach($requestData['buildComponentAddBuyLinks'] as $buyLink) {
            $buyLinkName = __('default_values.buy_link_default_name');

            if($buyLink['name'] != '') {
                $buyLinkName = $buyLink['name'];
            }

            $newBuyLink = new BuyLink();
            
            $newBuyLink->name = $buyLinkName;
            $newBuyLink->link = $buyLink['link'];
            $newBuyLink->price = $buyLink['price'];
            $newBuyLink->build_component_id = $buildComponent->id;

            if($buyLink['deliveryGroupId'] != null) {
                $newBuyLink->delivery_group_id = $buyLink['deliveryGroupId'];
            }

            $newBuyLink->save();
        }
    }


    public function updateBuyLinks($requestData) {
        foreach($requestData['buildComponentBuyLinks'] as $buyLinksArrayItem) {
            $buyLink = BuyLink::findOrFail($buyLinksArrayItem['id']);

            if($buyLink->name != $buyLinksArrayItem['name']) {
                $buyLink->name = $buyLinksArrayItem['name'];
            }

            if($buyLink->link != $buyLinksArrayItem['link']) {
                $buyLink->link = $buyLinksArrayItem['link'];
            }

            if($buyLink->price != $buyLinksArrayItem['price']) {
                $buyLink->price = $buyLinksArrayItem['price'];
            }

            if($buyLink->delivery_group_id != $buyLinksArrayItem['deliveryGroupId']) {
                if($buyLinksArrayItem['deliveryGroupId'] != null) {
                    $newDeliveryGroup = DeliveryGroup::findOrFail($buyLinksArrayItem['deliveryGroupId']);

                    $buyLink->delivery_group_id = $newDeliveryGroup->id;
                }
                else {
                    $buyLink->delivery_group_id = null;
                }
            }

            $buyLink->save();
        }
    }


    public function deleteFromDbDeletedClientSideBuyLinks($requestData, $buildComponent) {
        $buildComponentDbBuyLinksArray = BuyLink::where('build_component_id', $buildComponent->id)->pluck('id')->toArray();
        $buildComponentRequestBuyLinksArray = collect($requestData['buildComponentBuyLinks'])->pluck('id')->toArray();

        $buildComponentBuyLinksToDelete = array_diff($buildComponentDbBuyLinksArray, $buildComponentRequestBuyLinksArray);

        if(!empty($buildComponentBuyLinksToDelete)) {
            BuyLink::whereIn('id', $buildComponentBuyLinksToDelete)->delete();
        }
    }


    public function createBuildComponent($requestData) {
        $buildComponent = new BuildComponent();

        $buildComponent->name = $requestData['buildComponentName'];
        $buildComponent->type_id = $requestData['buildComponentTypeId'];
        $buildComponent->build_id = $requestData['buildComponentBuildId'];

        $buildComponent->save();

        return $buildComponent;
    }


    public function createDeliveryGroup($requestData, $deliveryGroupCost, $build) {
        $deliveryGroup = new DeliveryGroup();

        $deliveryGroup->name = $requestData['deliveryGroupName'];
        $deliveryGroup->user_id = Auth::id();
        $deliveryGroup->free_delivery_at = $requestData['deliveryGroupFreeDeliveryAt'];
        $deliveryGroup->delivery_cost = $deliveryGroupCost;
        $deliveryGroup->build_id = $build->id;
        $deliveryGroup->currency = 'RSD';

        $deliveryGroup->save();

        return $deliveryGroup;
    }


    public function updateDeliveryGroups($requestData) {
        foreach($requestData['deliveryGroups'] as $deliveryGroupsArrayItem) {
            $deliveryGroup = DeliveryGroup::findOrFail($deliveryGroupsArrayItem['id']);

            $this->checkIsUserDeliveryGroupOwnerJSON($deliveryGroup);

            if($deliveryGroup->name != $deliveryGroupsArrayItem['name']) {
                $deliveryGroup->name = $deliveryGroupsArrayItem['name'];
            }
            
            if($deliveryGroup->free_delivery_at != $deliveryGroupsArrayItem['freeDeliveryAt']) {
                $deliveryGroup->free_delivery_at = $deliveryGroupsArrayItem['freeDeliveryAt'];
            }

            if($deliveryGroup->delivery_cost != $deliveryGroupsArrayItem['deliveryCost']) {
                $deliveryGroup->delivery_cost = $deliveryGroupsArrayItem['deliveryCost'];
            }

            $deliveryGroup->save();
        }
    }


    public function deleteFromDbDeletedClientSideDeliveryGroups($requestData) {
        $buildId = $requestData['buildId'];

        if($buildId) {
            $deliveryGroupsArray = DeliveryGroup::where(function ($query) use ($buildId) {
                $query->where('build_id', $buildId)
                    ->orWhereNull('build_id');
            })
            ->where('user_id', Auth::id())
            ->pluck('id')
            ->toArray();
        }
        else {
            $deliveryGroupsArray = DeliveryGroup::where('user_id', Auth::id())->where('build_id', null)->pluck('id')->toArray();
        }
        $requestDeliveryGroupsArray = collect($requestData['deliveryGroups'])->pluck('id')->toArray();

        $deliveryGroupsToDelete = array_diff($deliveryGroupsArray, $requestDeliveryGroupsArray);

        if(!empty($deliveryGroupsToDelete)) {
            DeliveryGroup::whereIn('id', $deliveryGroupsToDelete)->delete();
        }
    }


    public function createDeliveryGroups($requestData) {
        foreach($requestData['addDeliveryGroups'] as $addDeliveryGroupsArrayItem) {
            $newDeliveryGroup = new DeliveryGroup();
            
            $newDeliveryGroup->name = $addDeliveryGroupsArrayItem['name'];
            $newDeliveryGroup->free_delivery_at = $addDeliveryGroupsArrayItem['freeDeliveryAt'];
            $newDeliveryGroup->delivery_cost = $addDeliveryGroupsArrayItem['deliveryCost'];
            $newDeliveryGroup->user_id = Auth::id();
            $newDeliveryGroup->currency = 'RSD';

            if($requestData['buildId']) {
                $newDeliveryGroup->build_id = $requestData['buildId'];
            }

            $newDeliveryGroup->save();
        }
    }
}