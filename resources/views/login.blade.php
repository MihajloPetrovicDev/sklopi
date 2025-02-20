<!DOCTYPE html>
<html lang="sr">
<head>
    <meta name="robots" content="noindex, nofollow">
    <x-base-head-tags />
    <title>@lang('ui.login.header_title')</title>
</head>

<body>
    <x-minimal-header />

    <main>
        <div class="section-1 mx-auto mt-80px w-450px pin-50px md-max-600px-w-80p">
            <h2 class="text-center">@lang('ui.login.login')</h2>

            <div id="error-container-placeholder"></div>

            <form class="mt-5" id="login-form">
                <label for="email">@lang('ui.login.email'):</label>
                <input class="form-control" type="email" id="email"></input>

                <label class="mt-3" for="password">@lang('ui.login.password'):</label>
                <input class="form-control" type="password" id="password"></input>

                <a class="mt-3 d-block text-end" href="/forgot-your-password">@lang('ui.login.forgot_your_password')?</a>

                <button class="mt-5 btn btn-primary mx-auto d-block" type="submit">@lang('ui.login.login')</button>
            </form>

            <div class="text-center mt-5">
                <p class="mb-0px">@lang('ui.login.dont_have_an_account')? <a href="/register"> @lang('ui.login.create_new_account').</a></p>
            </div>
        </div>
    </main>

    <x-footer />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    @vite('resources/js/inits/login_init.js')
</body>
</html>