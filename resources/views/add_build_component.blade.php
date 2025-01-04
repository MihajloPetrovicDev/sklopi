<!DOCTYPE html>
<html>
<head>
    <x-base-head-tags />
<title>@lang('ui.add_build_component.add_component'): {{ $build->name }} / @lang('component_types.name_by_id.'.$buildComponentTypeId) - sklopi</title>
</head>

<body>
    <x-header />

    <x-new-delivery-group-popup-window :build="$build" />

    <main>
        <h2 class="mt-5 text-center fs-1">@lang('ui.add_build_component.add_component'): {{ $build->name }} / @lang('component_types.name_by_id.'.$buildComponentTypeId)</h2>

        <div class="w-60p mx-auto" id="error-container-placeholder"></div>

        <div class="section-1 mx-auto mt-80px w-60p mb-5">
            <div class="w-85p mx-auto">
                <label for="component-name">@lang('ui.add_build_component.component_name'):</label>
                <input class="form-control mt-1" type="text" id="component-name"></input>
            
                <div id="buy-links-container">
                    <h3 class="text-center mt-5">@lang('ui.add_build_component.buy_links')</h3>
                </div>

                <div class="mt-4">
                    <button class="btn btn-primary mx-auto d-block" id="add-buy-link-button" data-build-id="{{ $build->id }}">+ @lang('ui.add_build_component.add_buy_link')</button>
                </div>

                <div class="mt-80px mx-auto w-fc">
                    <a class="btn btn-secondary" href="/build/{{ $encodedBuildId }}">@lang('ui.add_build_component.cancel')</a>
                    <button class="btn btn-primary" id="add-build-component-submit-button" data-type-id="{{ $buildComponentTypeId }}" data-build-id="{{ $build->id }}" data-encoded-build-id="{{ $encodedBuildId }}">@lang('ui.add_build_component.add')</button>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script type="module" src="{{ mix('resources/js/inits/add_build_component_init.js') }}"></script>
</body>
</html>