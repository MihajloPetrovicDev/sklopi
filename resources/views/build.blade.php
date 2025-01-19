<!DOCTYPE html>
<html>
<head>
    <x-base-head-tags />
    <title>{{ $build->name }} - sklopi</title>
</head>

<body>
    <x-header />

    <main>
        <div class="w-80p mx-auto mt-80px" id="error-container-placeholder"></div>

        <div class="d-flex mt-5 w-80p mx-auto align-items-center">
            <div class="w-20p">
                <a class="btn btn-primary h-50px pt-12px w-80p btn-text-truncate" href="/manage-delivery-groups?build={{ $build->encodedId }}">@lang('ui.build.manage_delivery_groups')</a>
            </div>

            <div class="w-60p">
                <div class="mx-auto d-flex w-70p">
                    <input class="form-control h-50px w-100p fs-3" id="build-name-input" value="{{ $build->name }}"></input>

                    <button class="btn btn-secondary h-50px w-100px ml-m-100px br-tl-0px br-bl-0px" id="save-build-name-button" data-build-id="{{ $build->id }}">@lang('ui.build.save')</button>
                </div>
            </div>

            <div class="w-20p">
                <button class="btn btn-danger h-50px float-end w-80p btn-text-truncate" id="delete-build-button" data-encoded-build-id="{{ $build->encodedId }}">@lang('ui.build.delete_build')</button>
            </div>
        </div>

        <x-builder :build="$build" :build-components="$buildComponents" :cheapest-buy-links-combination="$cheapestBuildComponentsBuyLinksCombination"/>
        
        <div class="section-1 mx-auto w-80p d-flex mt-5 mb-5 pin-50px align-items-center justify-content-between">
            <p class="mb-0 fs-5">@lang('ui.build.components_total'): {{ $buildTotals['combinationComponentTotal'] }} RSD</p>
            <p class="mb-0 fs-5">@lang('ui.build.delivery_total'): {{ $buildTotals['combinationDeliveryTotal'] }} RSD</p>
            <p class="mb-0 fs-3">@lang('ui.build.total'): <span class="fw-500">{{ $buildTotals['combinationTotal'] }} RSD</span></p>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script type="module" src="{{ mix('resources/js/inits/build_init.js') }}"></script>
</body>
</html>