<!DOCTYPE html>
<html lang="sr">
<head>
    <meta name="robots" content="noindex, nofollow">
    <x-base-head-tags />
    <title>@lang('ui.change_email_verification.header_title')</title>
</head>

<body>
    <x-header />

    <main>
        <div class="w-60p mt-5 mt-3 md-max-600px-w-80p mx-auto" id="error-container-placeholder"></div>

        <div class="w-60p mt-5 md-max-600px-w-80p mx-auto" id="message-container-placeholder"></div>
    </main>

    <x-footer />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script type="module" src="{{ mix('js/inits/change_email_verification_init.js') }}"></script>

</body>
</html>