<div class="new-delivery-group-popup-background d-none align-items-center z-1" id="new-delivery-group-popup-container">
    <div class="new-delivery-group-popup-window md-max-1200px-w-80p">
        <div>
            <h3 class="text-center mt-0px">@lang('ui.new_delivery_group_popup_window.create_delivery_group')</h3>
        </div>

        <div class="d-flex mt-5 md-max-1200px-d-block">
            <div class="w-30p md-max-1200px-w-100p">
                <label for="component-name">@lang('ui.new_delivery_group_popup_window.name'):</label>
                <input class="form-control mt-1" type="text" id="delivery-group-name"></input>
            </div>

            <div class="w-30p ml-5p md-max-1200px-ml-0px md-max-1200px-w-100p">
                <label for="component-name">@lang('ui.new_delivery_group_popup_window.free_delivery_at'):</label>
            
                <div class="d-flex mt-1">
                    <input class="form-control" type="text" id="delivery-group-free-delivery-at" placeholder="{{ __('ui.new_delivery_group_popup_window.optional') }}"></input>

                    <div class="w-80px ml-m-80px h-38px input-fixed-overlay-container br-tl-0px br-bl-0px">
                        <p class="mb-0px">RSD</p>
                    </div>
                </div>
            </div>

            <div class="w-30p ml-5p md-max-1200px-ml-0px md-max-1200px-w-100p">
                <label for="component-name">@lang('ui.new_delivery_group_popup_window.delivery_cost'):</label>
                
                <div class="d-flex mt-1">
                    <input class="form-control" type="text" id="delivery-group-delivery-cost"></input>

                    <div class="w-80px ml-m-80px h-38px input-fixed-overlay-container br-tl-0px br-bl-0px">
                        <p class="mb-0px">RSD</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mx-auto d-flex w-fc mt-5">
            <button class="btn btn-secondary" id="add-delivery-group-popup-window-cancel-button">@lang('ui.new_delivery_group_popup_window.cancel')</button>
            <button class="btn btn-primary ml-5px" id="add-delivery-group-popup-window-create-button" data-build-id="{{ $build->id }}">@lang('ui.new_delivery_group_popup_window.create')</button>
        </div>
    </div>
</div>