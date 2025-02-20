<!DOCTYPE html>
<html lang="sr">
<head>
    <x-base-head-tags />
    <title>@lang('ui.guest_build.header_title')</title>
</head>

<body>
    <x-header />

    <main>
        <div class="w-80p mx-auto mt-5" id="error-container-placeholder"></div>
        
        <main>
            <x-guest-builder />
        </main>

        <div class="section-1 mx-auto w-80p d-flex mt-5 pin-50px align-items-center justify-content-between md-max-1030px-d-block md-max-1200px-w-100p md-max-1200px-bin-none md-max-1200px-br-0px md-max-600px-pin-20px">
            <p class="mb-0 fs-3 ms-auto" id="build-total">@lang('ui.guest_build.total'): <span class="fw-500"></span></p>
        </div>
    </main>

    <x-footer />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    @vite('resources/js/inits/guest_build_init.js')
</body>
</html>