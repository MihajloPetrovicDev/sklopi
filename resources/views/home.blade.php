<!DOCTYPE html>
<html lang="sr">
<head>
    <x-base-head-tags />
    <title>@lang('ui.home.header_title')</title>
</head>

<body>
    <x-header />

    <main>
        <section class="mx-auto text-center mt-5 w-30p md-max-1030px-w-50p md-max-600px-w-70p">
            <h1 class="fs-1 w-70p mx-auto">@lang('ui.home.title')</h1>

            <p class="mt-4 fs-6 fw-light c-gray-1 w-100p">@lang('ui.home.sub_title')</p>
        
            <a class="btn btn-primary mx-auto mt-4" href="/my-builds">@lang('ui.home.build_pc')</a>
        </section>

        <section class="w-100p section-3 mt-120px">
            <img class="w-70p mx-auto d-block br-10px md-max-800px-w-100p" src="/images/ui/builder_screenshot.png"></img>

            <div class="mt-5 w-100p">
                <ul class="w-40p mx-auto mb-0px fs-4 md-max-1030px-w-60p md-max-600px-w-80p">
                    <li class="c-white-2 fw-200 mb-3">@lang('ui.home.enter_build_components_text')</li>
                    <li class="c-white-2 fw-200 mb-3">@lang('ui.home.enter_buy_links_text')</li>
                    <li class="c-white-2 fw-200 mb-3">@lang('ui.home.enter_delivery_groups_text')</li>
                    <li class="c-white-2 fw-200 mb-3">@lang('ui.home.we_will_choose_the_cheapest_option_text')</li>
                    <li class="c-white-2 fw-200">@lang('ui.home.because_of_builder_flexibility_text')</li>
                </ul>
            </div>
        </section>

        <section class="w-30p text-center mx-auto mt-120px md-max-1030px-w-50p md-max-600px-w-70p">
            <h2 class="fs-1 w-70p mx-auto">@lang('ui.home.dont_want_to_look_alone_text')</h2>

            <div class="d-flex mt-5 gap-2 mx-auto w-fc align-items-center md-max-600px-d-flex md-max-600px-f-wrap-wrap">
                <p class="mb-0px fw-light">@lang('ui.home.look_trough')</p>
                <a class="btn btn-primary" href="/builds">@lang('ui.home.public_builds')</a>
                <p class="mb-0px fw-light">@lang('ui.home.and')</p>
                <a class="btn btn-primary" href="/discussions">@lang('ui.home.discussions')</a>
            </div>
        </section>
    </main>

    <x-footer />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>