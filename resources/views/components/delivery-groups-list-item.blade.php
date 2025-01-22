<div class="d-flex mx-auto w-100p section-2" data-delivery-group-id="{{ $deliveryGroup->id }}">
    <div class="d-flex w-90p">
        <div class="w-30p">
            <label for="component-name">@lang('ui.delivery_groups_list_item.name'):</label>
            <input class="form-control mt-1 delivery-group-name" type="text" value="{{ $deliveryGroup->name }}"></input>
        </div>

        <div class="w-30p ml-5p">
            <label for="component-name">@lang('ui.delivery_groups_list_item.free_delivery_at'):</label>
            <div class="d-flex mt-1">
                <input class="form-control delivery-group-free-delivery-at" type="text" value="{{ $deliveryGroup->free_delivery_at }}" placeholder="{{ __('ui.delivery_groups_list_item.optional') }}"></input>
            
                <div class="w-80px ml-m-80px h-38px input-fixed-overlay-container br-tl-0px br-bl-0px">
                    <p class="mb-0px">{{ $deliveryGroup->currency }}</p>
                </div>
            </div>
        </div>

        <div class="w-30p ml-5p">
            <label for="component-name">@lang('ui.delivery_groups_list_item.delivery_cost'):</label>
            <div class="d-flex mt-1">
                <input class="form-control delivery-group-delivery-cost" type="text" value="{{ $deliveryGroup->delivery_cost }}"></input>
        
                <div class="w-80px ml-m-80px h-38px input-fixed-overlay-container br-tl-0px br-bl-0px">
                    <p class="mb-0px">{{ $deliveryGroup->currency }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="w-10p d-flex justify-content-between">
        <button class="span-button-red ms-auto w-fc pin-0px delete-delivery-group-button">
            <span class="material-symbols-outlined">delete</span>
        </button>
    </div>
</div>