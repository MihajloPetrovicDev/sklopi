<!DOCTYPE html>
<html>
<head>
    <x-base-head-tags />
    <title>@lang('ui.builder.header_title')</title>
</head>

<body>
    <x-header />

    <main>
        <h2 class="mt-5 text-center fs-1">@lang('ui.builder.my_builds')</h2>

        <div class="section-1 mx-auto mt-80px w-60p">
            <form class="h-38px" action="/api/new-build" method="post">
                @csrf
                <button class="btn btn-primary float-end mt-0" type="submit">+ @lang('ui.builder.new_build')</button>
            </form>

            @if(!$builds->isEmpty())
                @foreach ($builds as $build)

                @endforeach   
            @else
                <p class="text-center mb-0px mt-5 fw-light fst-italic c-gray">@lang('ui.builder.no_builds')</p>
            @endif
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>