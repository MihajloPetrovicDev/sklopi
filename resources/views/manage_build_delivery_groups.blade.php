<!DOCTYPE html>
<html>
<head>
    <x-base-head-tags />
    <title>@lang('ui.manage_delivery_groups.manage_delivery_groups'){{ $build ? ': '.$build->name : '' }} - sklopi</title>
</head>

<body>
    <x-header />

    <main>
        <h2 class="mt-5 text-center fs-1">@lang('ui.manage_delivery_groups.manage_delivery_groups'){{ $build ? ': '.$build->name : '' }}</h2>
            @if($build)
                <div class="w-70p mx-auto section-1 mt-5">
                    <h3 class="text-center">@lang('ui.manage_delivery_groups.local_delivery_groups')</h3>

                    <div class="mt-5 d-flex flex-column gap-4">
                        @foreach($buildDeliveryGroups as $buildDeliveryGroup)
                            <x-delivery-groups-list-item :delivery-group="$buildDeliveryGroup" />
                        @endforeach
                    </div>
                </div>
            @else

            @endif

            <div class="d-flex gap-2 mx-auto mt-5 w-fc mb-5">
                <a class="btn btn-secondary" href="{{ $build ? '/build/'.$build->encodedId : '/my-builds' }}">@lang('ui.delivery_groups_list_item.cancel')</a>

                <button class="btn btn-primary" id="save-delivery-groups-button">@lang('ui.delivery_groups_list_item.save')</button>
            </div>
        <div class="w-60p mx-auto" id="error-container-placeholder"></div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    {{-- <script type="module" src="{{ mix('resources/js/inits/manage_delivery_groups_init.js') }}"></script> --}}
</body>
</html>