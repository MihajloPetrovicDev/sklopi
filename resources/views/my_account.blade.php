<!DOCTYPE html>
<html lang="sr">
<head>
    <meta name="robots" content="noindex, nofollow">
    <x-base-head-tags />
    <title>@lang('ui.my_account.header_title')</title>
</head>

<body>
    <x-my-account-header />

    <form action="/api/log-out" method="post">
        @csrf
        <button class="btn btn-danger log-out-btn" type="submit">@lang('ui.my_account.log_out')</button>
    </form>

    <h2 class="mt-5 text-center fs-1">@lang('ui.my_account.my_account')</h2>

    <div class="w-50p mt-3 md-max-1400px-w-70p md-max-600px-w-80p mx-auto" id="error-container-placeholder"></div>

    <div class="w-50p mt-3 md-max-1400px-w-70p md-max-600px-w-80p mx-auto" id="message-container-placeholder"></div>

    <main>
        <div class="w-50p mx-auto mt-5 section-1 md-max-1400px-w-70p md-max-800px-w-100p md-max-800px-bin-none md-max-800px-br-0px">
            <div class="w-90p mx-auto">
                <div class="d-flex align-items-center md-max-800px-d-block bb-lgray pb-4">
                    <p class="mb-0px w-20p text-end md-max-800px-w-100p md-max-800px-text-start">@lang('ui.my_account.username'):</p>

                    <div class="d-flex w-75p ml-5p md-max-800px-ml-0px md-max-800px-w-100p">
                        <input class="form-control" value="{{ $user->username }}"></input>
                    
                        <button class="btn btn-primary w-100px ml-m-100px br-tl-0px br-bl-0px" id="save-username-button">@lang('ui.build.save')</button>
                    </div>
                </div>

                <div class="d-flex align-items-center mt-4 md-max-800px-d-block bb-lgray pb-4">
                    <p class="mb-0px w-20p text-end md-max-800px-w-100p md-max-800px-text-start">@lang('ui.my_account.email'):</p>

                    <p class="ml-5p w-50p mb-0px fw-light fst-italic text-break md-max-800px-w-100p md-max-800px-ml-0px" id="email-text">{{ $user->email }}</p>

                    <div class="ml-5p w-20p d-flex justify-content-end md-max-800px-w-100p md-max-800px-ml-0px md-max-800px-mt-10px md-max-800px-justify-content-start">
                        <a class="btn btn-primary" href="/change-email">@lang('ui.my_account.change')</a>
                    </div>
                </div>

                <div class="d-flex align-items-center mt-4">
                    <button class="btn btn-primary mx-auto" id="change-password-button">@lang('ui.my_account.change_password')</button>
                </div>
            </div>
        </div>
    </main>

    <x-footer />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script type="module" src="{{ mix('js/inits/my_account_init.js') }}"></script> 
</body>
</html>