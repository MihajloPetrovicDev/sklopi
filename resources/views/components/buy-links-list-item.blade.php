<div class="section-2 gap-5 w-100p mt-3 pb-0px" data-buy-link-id="{{ $buyLink->id }}">
    {{-- Top row --}}
    <div class="d-flex mt-1">
        {{-- Buy link name --}}
        <div class="w-48p">
            <label for="buy-link-name">@lang('ui.build_component.buy_link_name'):</label>
            <input class="form-control mt-1 buy-link-name" id="buy-link-name" placeholder="Opcionalno" value="{{ $buyLink->name }}">
        </div>

        {{-- Buy link link --}}
        <div class="w-47p ml-5p">
            <label for="buy-link-link">@lang('ui.build_component.buy_link_link'):</label>
            <input class="form-control mt-1 buy-link-link" id="buy-link-link" value="{{ $buyLink->link }}">
        </div>
    </div>


    {{-- Bottom row --}}
    <div class="d-flex mt-3">
        {{-- Buy link price --}}
        <div class="w-20p">
            <label for="buy-link-price">@lang('ui.build_component.buy_link_price'):</label>
            <input class="form-control mt-1 buy-link-price" id="buy-link-price" placeholder="Opcionalno" value="{{ $buyLink->price }}">
        </div>

        {{-- Buy link delivery group container --}}
        <div class="d-flex w-75p ml-5p">
            <div class="w-60p pr-10px">
                <label for="buy-link-delivery-group-select">@lang('ui.build_component.buy_link_delivery_group'):</label>

                <select class="form-select h-38px mt-1 buy-link-delivery-group buy-link-delivery-group-select" id="buy-link-delivery-group-select">
                    <option></option>
                    
                    @foreach($buildDeliveryGroups as $buildDeliveryGroup)
                        <option value="{{ $buildDeliveryGroup->id }}" {{ $buyLink->delivery_group_id == $buildDeliveryGroup->id ? 'selected' : '' }}>{{ $buildDeliveryGroup->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="w-40p">
                <button class="btn btn-primary h-38px mt-28px w-100p buy-link-new-delivery-group-button btn-text-truncate" type="button">+ @lang('ui.build_component.buy_link_new_delivery_group')</button>
            </div>
        </div>
    </div>


    {{-- Delete buy link button --}}
    <button class="buy-link-delete-button">
        <span class="material-symbols-outlined">delete</span>
    </button>
</div>