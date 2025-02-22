<!DOCTYPE html>
<html lang="sr">
<head>
    <x-base-head-tags />
    <meta name="description" content="{{ __('meta_descriptions.my_builds') }}">
    <title>@lang('ui.my_builds.header_title')</title>
</head>

<body>
    <x-header />

    <main>
        <h2 class="mt-5 text-center fs-1">@lang('ui.my_builds.my_builds')</h2>

        <div class="section-1 mx-auto mt-80px w-60p md-max-600px-w-80p">
            <div class="h-38px mb-5">
                <a class="btn btn-primary float-end mt-0" href="/create-new-build">+ @lang('ui.my_builds.new_build')</a>
            </div>

            @if(Auth::check())
                @if(!$builds->isEmpty())
                    @foreach ($builds as $build)
                        <x-builds-list-item :build="$build" />
                    @endforeach   
                @else
                    <p class="text-center mb-0px mt-5 fw-light fst-italic c-gray-1">@lang('ui.my_builds.no_builds')</p>
                @endif
            @else
                <a class="clean-link c-black-1" href="/guest-build">
                    <div class="section-2 w-100p mt-5 hover-bgc-gray hover-pointer">
                        <p class="mb-0px">@lang('ui.my_builds.guest_build')</p>
                    </div>
                </a>

                <p class="mb-0px mt-5 text-center fw-light fst-italic c-gray-1">@lang('ui.my_builds.login_for_more_builds')</p>
            @endif
        </div>
    </main>

    <x-footer />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>