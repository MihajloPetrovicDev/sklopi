<!DOCTYPE html>
<html lang="sr">
<head>
    <meta name="robots" content="noindex, nofollow">
    <x-base-head-tags />
    <title>{{ $build->name }} - sklopi</title>
</head>

<body>
    <x-header />

    <main>
        <div class="w-80p mx-auto mt-5" id="error-container-placeholder"></div>

        <div class="d-flex mt-5 w-80p mx-auto align-items-center md-max-900px-d-block md-max-900px-mb-100px">
            <div class="w-20p md-max-900px-w-100p">
                <a class="btn btn-primary h-45px pt-10px w-80p btn-text-truncate md-max-900px-w-100p" href="/manage-delivery-groups?build={{ $build->encodedId }}">@lang('ui.build.manage_delivery_groups')</a>
            </div>

            <div class="w-60p md-max-900px-w-100p md-max-900px-mt-15px">
                <div class="w-80p mx-auto md-max-900px-w-100p">
                    <div class="mx-auto d-flex align-items-center">
                        <label class="fs-4 fw-light w-17p text-end" for="save-build-name-button">@lang('ui.build.name'):</label>

                        <input class="ml-2p form-control h-45px w-80p fs-3" id="build-name-input" value="{{ $build->name }}"></input>

                        <button class="btn btn-primary h-45px w-100px ml-m-100px br-tl-0px br-bl-0px" id="save-build-name-button" data-build-id="{{ $build->id }}">@lang('ui.build.save')</button>
                    </div>
                </div>
            </div>

            <div class="w-20p md-max-900px-w-100p md-max-900px-mt-15px">
                <button class="btn btn-danger h-45px float-end w-80p btn-text-truncate md-max-900px-w-100p" id="delete-build-button" data-encoded-build-id="{{ $build->encodedId }}">@lang('ui.build.delete_build')</button>
            </div>
        </div>

        <x-builder :build="$build" :build-components="$buildComponents" :cheapest-buy-links-combination="$cheapestBuildComponentsBuyLinksCombination"/>
        
        <div class="section-1 mx-auto w-80p d-flex mt-5 pin-50px align-items-center justify-content-between gap-5 md-max-1030px-d-block md-max-1200px-w-100p md-max-1200px-bin-none md-max-1200px-br-0px md-max-600px-pin-20px">
            <p class="mb-0 fs-5">@lang('ui.build.components_total'): <span class="fw-500">@formatToComaDecimalSeparator($buildTotals['combinationComponentTotal']) RSD</span></p>
            <p class="mb-0 fs-5 md-max-1030px-mt-10px">@lang('ui.build.delivery_total'): <span class="fw-500">@formatToComaDecimalSeparator($buildTotals['combinationDeliveryTotal']) RSD</span></p>
            <p class="mb-0 fs-3 md-max-1030px-mt-30px">@lang('ui.build.total'): <span class="fw-500">@formatToComaDecimalSeparator($buildTotals['combinationTotal']) RSD</span></p>
        </div>
    </main>

    <x-footer />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script type="module" src="{{ mix('js/inits/build_init.js') }}"></script>
</body>
</html>