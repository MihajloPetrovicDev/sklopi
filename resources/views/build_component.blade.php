<!DOCTYPE html>
<html lang="sr">
<head>
    <meta name="robots" content="noindex, nofollow">
    <x-base-head-tags />
    <title>@lang('ui.build_component.component'): {{ $buildComponent->build->name }} / @lang('component_types.name_by_id.'.$buildComponent->type_id) - sklopi</title>
</head>

<body>
    <x-header />

    <x-new-delivery-group-popup-window :build="$buildComponent->build" />

    <main>
        <h2 class="mt-5 text-center fs-1">@lang('ui.build_component.component'): {{ $buildComponent->build->name }} / @lang('component_types.name_by_id.'.$buildComponent->type_id)</h2>

        <div class="w-60p mx-auto" id="error-container-placeholder"></div>

        <div class="section-1 mx-auto mt-80px w-60p md-max-1200px-w-100p md-max-1200px-bin-none md-max-1200px-br-0px md-max-1200px-pin-20px">
            <div class="w-85p mx-auto">
                <label for="component-name">@lang('ui.build_component.component_name'):</label>
                <input class="form-control mt-1" type="text" id="component-name" value="{{ $buildComponent->name }}"></input>
            
                <div id="buy-links-container">
                    <h3 class="text-center mt-5">@lang('ui.build_component.buy_links')</h3>

                    @foreach($buildComponent->buyLinks as $buyLink)
                        <x-buy-links-list-item :buy-link="$buyLink" :build-delivery-groups="$buildDeliveryGroups"/>
                    @endforeach
                </div>

                <div class="mt-4">
                    <button class="btn btn-primary mx-auto d-block" id="add-buy-link-button" data-build-id="{{ $buildComponent->build->id }}">+ @lang('ui.build_component.add_buy_link')</button>
                </div>

                <div class="mt-80px mx-auto w-fc">
                    <a class="btn btn-secondary" href="/build/{{ $buildComponent->build->encoded_id }}">@lang('ui.build_component.cancel')</a>
                    <button class="btn btn-primary" id="build-component-save-button" data-build-component-id="{{ $buildComponent->id }}" data-encoded-build-id="{{ $buildComponent->build->encoded_id }}">@lang('ui.build_component.save')</button>
                </div>
            </div>
        </div>
    </main>

    <x-footer />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script type="module" src="{{ mix('js/inits/build_component_init.js') }}"></script>
</body>
</html>