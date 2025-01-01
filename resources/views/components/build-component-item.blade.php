<div class="h-fc mbl-10px w-100p">
    @if($buildComponent != null)
        <div class="section-2 w-100p">
            <p class="mb-0px">{{ $buildComponent->name }}</p>
        </div>
    @else
        <a class="btn btn-primary" href="/add-build-component/?build-id={{ $encodedBuildId }}&build-component-type-id={{ $buildComponentTypeId }}">+ @lang('ui.build.add_component')</a>
    @endif
</div>