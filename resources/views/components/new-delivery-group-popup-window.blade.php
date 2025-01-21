<div class="new-delivery-group-popup-background d-none align-items-center z-1" id="new-delivery-group-popup-container">
    <div class="new-delivery-group-popup-window">
        <div>
            <h3 class="text-center mt-0px">@lang('ui.new_delivery_group_popup_window.create_delivery_group')</h3>
        </div>

        <div class="d-flex mt-5">
            <div class="w-30p">
                <label for="component-name">@lang('ui.new_delivery_group_popup_window.name'):</label>
                <input class="form-control mt-1" type="text" id="delivery-group-name"></input>
            </div>

            <div class="w-30p ml-5p">
                <label for="component-name">@lang('ui.new_delivery_group_popup_window.free_delivery_at'):</label>
                <input class="form-control mt-1" type="text" id="delivery-group-free-delivery-at" placeholder="{{ __('ui.new_delivery_group_popup_window.optional') }}"></input>
            </div>

            <div class="w-30p ml-5p">
                <label for="component-name">@lang('ui.new_delivery_group_popup_window.delivery_cost'):</label>
                <input class="form-control mt-1" type="text" id="delivery-group-delivery-cost" placeholder="{{ __('ui.new_delivery_group_popup_window.optional') }}"></input>
            </div>
        </div>

        <div class="mx-auto d-flex w-fc mt-5">
            <button class="btn btn-secondary" id="add-delivery-group-popup-window-cancel-button">@lang('ui.new_delivery_group_popup_window.cancel')</button>
            <button class="btn btn-primary ml-5px" id="add-delivery-group-popup-window-create-button" data-build-id="{{ $build->id }}">@lang('ui.new_delivery_group_popup_window.create')</button>
        </div>
    </div>
</div>