<!DOCTYPE html>
<html lang="sr">
<head>
    <meta name="robots" content="noindex, nofollow">
    <x-base-head-tags />
    <title>@lang('ui.redirect_to_buy_link.header_title')</title>
</head>

<body>
    <x-header />

    <main>
        <h2 class="mx-auto text-center mt-80px fs-1 w-90p">@lang('ui.redirect_to_buy_link.you_will_be_redirected')</h2>

        <p class="mx-auto text-center mt-5 fs-1-2r fw-light w-60p md-max-600px-w-80p">@lang('ui.redirect_to_buy_link.sklopi_cant_guarantee_safety')</p>

        <p class="mx-auto text-center w-60p mt-80px fs-4 md-max-600px-w-80p">{{ $buyLink }}</p>

        <div class="mx-auto w-fc mt-5">
            <a class="btn btn-primary" href="{{ (strpos($buyLink, 'http') === 0) ? $buyLink : '//'.$buyLink }}">@lang('ui.redirect_to_buy_link.visit_link')</a>
        </div>
    </main>

    <x-footer />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>