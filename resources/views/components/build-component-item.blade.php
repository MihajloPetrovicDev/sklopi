<div class="h-fc mbl-10px w-100p">
    @if($buildComponent != null)
        <div class="d-flex section-2 w-100p">
            <div class="w-90p">
                <p class="mb-0px">{{ $buildComponent->name }}</p>
            </div>

            <button class="span-button-black h-28px w-5p build-component-settings-button" data-encoded-build-component-id="{{ $encodedBuildComponentId }}">
                <span class="material-symbols-outlined">settings</span>
            </button>

            <button class="span-button-red h-28px w-5p d-flex build-component-delete-button" build-component-id="{{ $buildComponent->id }}">
                <span class="material-symbols-outlined ms-auto">delete</span>
            </button>
        </div>
    @else
        <a class="btn btn-primary" href="/add-build-component/?build-id={{ $encodedBuildId }}&build-component-type-id={{ $buildComponentTypeId }}">+ @lang('ui.build.add_component')</a>
    @endif
</div>