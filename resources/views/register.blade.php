<!DOCTYPE html>
<html>
<head>
    <x-base-head-tags />
    <title>@lang('ui.register.header_title')</title>
</head>

<body>
    <x-minimal-header />

    <main>
        <div class="section-1 mx-auto mt-80px w-450px pin-50px md-max-600px-w-90p">
            <h2 class="text-center">@lang('ui.register.register')</h2>

            <div id="error-container-placeholder"></div>

            <form class="mt-5" id="register-form">
                <label for="email">@lang('ui.register.username'):</label>
                <input class="form-control" type="text" id="username"></input>

                <label class="mt-3" for="email">@lang('ui.register.email'):</label>
                <input class="form-control" type="email" id="email"></input>

                <label class="mt-3" for="password">@lang('ui.register.password'):</label>
                <input class="form-control" type="password" id="password"></input>

                <label class="mt-3" for="password">@lang('ui.register.confirm_password'):</label>
                <input class="form-control" type="password" id="confirm-password"></input>

                <div class="d-flex">
                    <input class="form-check" type="checkbox" id="tos-privacy-policy-check"></input>
                    <label class="mt-21px ml-15px" for="tos-privacy-policy-check">
                        @lang('ui.register.i_accept') <a href="/terms-of-service" target="_blank">@lang('ui.register.terms_of_service')</a> @lang('ui.register.and') <a href="/privacy-policy" target="_blank">@lang('ui.register.privacy_policy')</a>
                    </label>
                </div>

                <button class="mt-5 btn btn-primary mx-auto d-block" type="submit">@lang('ui.register.register')</button>
            </form>

            <div class="text-center mt-5">
                <p class="mb-0px">@lang('ui.register.have_an_account')? <a href="/login"> @lang('ui.register.login').</a></p>
            </div>
        </div>
    </main>

    <x-footer />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script type="module" src="{{ mix('resources/js/inits/register_init.js') }}"></script> 
</body>
</html>