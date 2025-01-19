<div class="d-flex mx-auto w-95p section-2">
    <div class="d-flex w-90p">
        <div class="w-30p">
            <label for="component-name">@lang('ui.delivery_groups_list_item.name'):</label>
            <input class="form-control mt-1" type="text" id="delivery-group-name" value="{{ $deliveryGroup->name }}"></input>
        </div>

        <div class="w-30p ml-5p">
            <label for="component-name">@lang('ui.delivery_groups_list_item.free_delivery_at'):</label>
            <div class="d-flex mt-1">
                <input class="form-control" type="text" id="delivery-group-free-delivery-at" value="{{ $deliveryGroup->free_delivery_at }}" placeholder="{{ __('ui.delivery_groups_list_item.optional') }}"></input>
            
                <div class="w-80px ml-m-80px h-38px input-fixed-overlay-container br-tl-0px br-bl-0px">
                    <p class="mb-0px">{{ $deliveryGroup->currency }}</p>
                </div>
            </div>
        </div>

        <div class="w-30p ml-5p">
            <label for="component-name">@lang('ui.delivery_groups_list_item.delivery_cost'):</label>
            <div class="d-flex mt-1">
                <input class="form-control" type="text" id="delivery-group-delivery-cost" value="{{ $deliveryGroup->delivery_cost }}"></input>
        
                <div class="w-80px ml-m-80px h-38px input-fixed-overlay-container br-tl-0px br-bl-0px">
                    <p class="mb-0px">{{ $deliveryGroup->currency }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="w-10p d-flex justify-content-between">
        <button class="span-button-red ms-auto w-fc pin-0px">
            <span class="material-symbols-outlined">delete</span>
        </button>
    </div>
</div>