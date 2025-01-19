<div class="h-fc mbl-10px w-100p">
    @if($buildComponent != null)
        <div class="d-flex section-2 w-100p">
            <div class="w-50p">
                <p class="mb-0px">{{ $buildComponent->name }}</p>
            </div>

            @if($buildComponentBuyLink)
                <div class="w-20p">
                    <a href="{{ (strpos($buildComponentBuyLink->link, 'http') === 0) ? $buildComponentBuyLink->link : '//'.$buildComponentBuyLink->link }}" title="{{ $buildComponentBuyLink->link }}" target="_blank">{{ $buildComponentBuyLink->name }}</a>
                </div>

                <div class="w-20p">
                    <p class="mb-0px">{{ $buildComponentBuyLink->price == null ? '--' : $buildComponentBuyLink->price }} RSD</p>
                </div>
            @endif

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