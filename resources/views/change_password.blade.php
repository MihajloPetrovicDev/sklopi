<!DOCTYPE html>
<html lang="sr">
<head>
    <meta name="robots" content="noindex, nofollow">
    <x-base-head-tags />
    <title>@lang('ui.change_password.header_title')</title>
</head>

<body>
    <x-header />

    <main>
        <h1 class="text-center mt-5 fs-2">@lang('ui.change_password.change_password')</h1>

        <div class="w-30p md-max-1030px-w-50p md-max-600px-w-80p mx-auto" id="error-container-placeholder"></div>

        <div class="section-1 mx-auto mt-5 w-30p pin-50px md-max-1030px-w-50p md-max-600px-w-80p">
            <div class="w-100p mx-auto">
                <div>
                    <label for="new-password">@lang('ui.change_password.new_password'):</label>
                    <input class="form-control mt-1" type="password" id="new-password"></input>
                </div>

                <div class="mt-3">
                    <label for="confirm-new-password">@lang('ui.change_password.confirm_new_password'):</label>
                    <input class="form-control mt-1" type="password" id="confirm-new-password"></input>
                </div>

                <div class="mt-5 mx-auto w-fc">
                    <a class="btn btn-secondary" href="/">@lang('ui.change_password.cancel')</a>
                    <button class="btn btn-primary" id="change-password-confirm-button">@lang('ui.change_password.confirm')</button>
                </div>
            </div>
        </div>
    </main>

    <x-footer />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    @vite('resources/js/inits/change_password_init.js')
</body>
</html>