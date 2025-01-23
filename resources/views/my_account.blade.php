<!DOCTYPE html>
<html>
<head>
    <meta name="robots" content="noindex, nofollow">
    <x-base-head-tags />
    <title>@lang('ui.my_account.header_title')</title>
</head>

<body>
    <x-minimal-header />

    <form action="/api/log-out" method="post">
        @csrf
        <button class="btn btn-danger log-out-btn" type="submit">@lang('ui.my_account.log_out')</button>
    </form>

    <main>

    </main>

    <x-footer />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>