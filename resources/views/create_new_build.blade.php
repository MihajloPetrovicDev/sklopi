<!DOCTYPE html>
<html>
<head>
    <meta name="robots" content="noindex, nofollow">
    <x-base-head-tags />
    <title>@lang('ui.create_new_build.header_title')</title>
</head>

<body>
    <x-header />

    <main>
        <h2 class="mt-5 text-center fs-1">@lang('ui.create_new_build.create_new_build')</h2>

        <div class="w-40p mx-auto" id="error-container-placeholder"></div>

        <div class="section-1 mx-auto mt-80px w-40p md-max-1030px-w-60p md-max-600px-w-80p">
            <form id="create-new-build-form">
                <label for="build-name">@lang('ui.create_new_build.build_name'):</label>
                <input class="form-control mt-1" type="text" id="build-name" placeholder="{{ __('ui.create_new_build.optional') }}"></input>

                <p class="mt-4 mb-0px">@lang('ui.create_new_build.visibility'):</p>

                <div class="d-flex">
                    <div>
                        <input type="radio" name="buildVisibility" id="build-visibility-private" value="false" checked></input>
                        <label class="fw-light" for="build-visibility-private">@lang('ui.create_new_build.private')</label>
                    </div>

                    <div class="ml-20px">
                        <input type="radio" name="buildVisibility" id="build-visibility-public" value="true"></input>
                        <label class="fw-light" for="build-visibility-public">@lang('ui.create_new_build.public')</label>
                    </div>
                </div>

                <div class="mt-5 mx-auto w-fc">
                    <a class="btn btn-secondary" href="/my-builds">@lang('ui.create_new_build.cancel')</a>
                    <button class="btn btn-primary" type="submit">@lang('ui.create_new_build.create')</button>
                </div>
            </form>
        </div>
    </main>

    <x-footer />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script type="module" src="{{ mix('js/inits/create_new_build_init.js') }}"></script> 
</body>
</html>