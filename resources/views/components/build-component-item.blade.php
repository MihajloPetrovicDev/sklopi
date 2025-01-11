<div class="h-fc mbl-10px w-100p">
    @if($buildComponent != null)
        <div class="d-flex section-2 w-100p">
            <div class="w-90p">
                <p class="mb-0px">{{ $buildComponent->name }}</p>
            </div>

            <div class="d-flex w-10p">
                <a class="span-button-black h-24px build-component-settings-button" href="/build-component/{{ $buildComponent->encodedId }}">
                    <span class="material-symbols-outlined mx-auto">settings</span>
                </a>

                <button class="span-button-red h-24px build-component-delete-button ms-auto pin-0px" build-component-id="{{ $buildComponent->id }}">
                    <span class="material-symbols-outlined">delete</span>
                </button>
            </div>
        </div>
    @else
        <a class="btn btn-primary" href="/add-build-component/?build-id={{ $build->encodedId }}&build-component-type-id={{ $buildComponentTypeId }}">+ @lang('ui.build.add_component')</a>
    @endif
</div>