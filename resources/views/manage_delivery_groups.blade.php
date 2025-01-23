<!DOCTYPE html>
<html>
<head>
    <meta name="robots" content="noindex, nofollow">
    <x-base-head-tags />
    <title>@lang('ui.manage_delivery_groups.manage_delivery_groups'){{ $build ? ': '.$build->name : '' }} - sklopi</title>
</head>

<body>
    <x-header />

    <x-new-delivery-group-popup-window :build="$build" />

    <main>
        <h2 class="mt-5 text-center fs-1">@lang('ui.manage_delivery_groups.manage_delivery_groups'){{ $build ? ': '.$build->name : '' }}</h2>
        
        <div class="w-70p mx-auto" id="error-container-placeholder"></div>

        @if($build)
            <div class="w-70p mx-auto section-1 mt-5 pin-50px">
                <div class="w-100p d-flex">
                    <div class="w-20p"></div>

                    <div class="w-60p">
                        <h3 class="text-center">@lang('ui.manage_delivery_groups.local_delivery_groups')</h3>
                    </div>

                    <div class="w-20p">
                        <button class="btn btn-primary btn-text-truncate float-end w-100p" id="new-delivery-group-button">+ @lang('ui.manage_delivery_groups.new_delivery_group')</button>
                    </div>
                </div>

                <p class="mt-5 h-0px text-center fw-light fst-italic c-gray-1">@lang('ui.manage_delivery_groups.no_delivery_groups')</p>

                <div class="d-flex flex-column gap-4 mt-m-20px min-h-25px" id="delivery-groups-container">
                    @foreach($buildDeliveryGroups as $buildDeliveryGroup)
                        <x-delivery-groups-list-item :delivery-group="$buildDeliveryGroup" />
                    @endforeach
                </div>
            </div>
        @else

        @endif

        <div class="d-flex mx-auto mt-5 w-fc">
            <a class="btn btn-secondary" href="{{ $build ? '/build/'.$build->encodedId : '/my-builds' }}">@lang('ui.delivery_groups_list_item.cancel')</a>

            <button class="btn btn-primary ml-5px" id="save-delivery-groups-button" data-encoded-build-id="{{ $build->encodedId }}" data-build-id="{{ $build->id }}">@lang('ui.delivery_groups_list_item.save')</button>
        </div>
    </main>

    <x-footer />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script type="module" src="{{ mix('resources/js/inits/manage_delivery_groups_init.js') }}"></script>
</body>
</html>