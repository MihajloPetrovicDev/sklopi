<!DOCTYPE html>
<html>
<head>
    <x-base-head-tags />
    <title>{{ $build->name }} - sklopi</title>
</head>

<body>
    <x-header />

    <main>
        <h2 class="mt-5 text-center fs-1">{{ $build->name }}</h2>

        <x-builder :build="$build" :build-components="$buildComponents" />
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script type="module" src="{{ mix('resources/js/inits/build_init.js') }}"></script>
</body>
</html>