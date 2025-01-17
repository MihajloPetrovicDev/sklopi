<!DOCTYPE html>
<html>
<head>
    <x-base-head-tags />
    <title>{{ $build->name }} - sklopi</title>
</head>

<body>
    <x-header />

    <main>
        <h2 class="mt-5 text-center fs-1">{{ $build->name }}</h2>

        <x-builder :build="$build" :build-components="$buildComponents" />

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