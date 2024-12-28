<div class="h-fc mbl-10px w-100p">
    @if($buildComponent != null)
        <div class="section-2 w-100p">
            <p class="mb-0px">{{ $buildComponent->name }}</p>
        </div>
    @else
        <button class="btn btn-primary">+ @lang('ui.build.add_component')</button>
    @endif
</div>