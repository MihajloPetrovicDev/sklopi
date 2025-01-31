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
        <div class="w-40p mx-auto mt-5 section-1 md-max-1400px-w-65p">
            <div class="w-80p mx-auto">
                <div class="d-flex align-items-center md-max-800px-d-block">
                    <p class="mb-0px w-20p text-end md-max-800px-w-100p md-max-800px-text-start">@lang('ui.my_account.username'):</p>

                    <input class="form-control ml-5p w-75p md-max-800px-w-100p md-max-800px-ml-0px" value="{{ $user->username }}"></input>
                </div>

                <div class="d-flex align-items-center mt-3 md-max-800px-d-block">
                    <p class="mb-0px w-20p text-end md-max-800px-w-100p md-max-800px-text-start">@lang('ui.my_account.email'):</p>

                    <input class="form-control ml-5p w-75p md-max-800px-w-100p md-max-800px-ml-0px" value="{{ $user->email }}"></input>
                </div>
            </div>
        </div>
    </main>

    <x-footer />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>