<?php $hasComponent = false ?>

<div class="mx-auto w-80p section-1 mt-5 pbl-20px">


    
    {{-- CPU / Type = 1 --}}
    <div class="d-flex align-items-center">
        <p class="fs-4 w-15p text-end pr-2p mb-0px">CPU</p>

        <div class="bb-lgray w-85p pin-20px pbl-10px">
            {{-- Check trough the buildComponents list to see if there is a CPU component. If there is --}}
            {{-- show the component and update the $hasComponent to true. --}}
            @foreach($buildComponents as $buildComponent)
                @if($buildComponent->type_id == 1)
                    <x-build-component-item :build-component="$buildComponent" :cheapest-buy-links-combination="$cheapestBuyLinksCombination" />
                    <?php $hasComponent = true ?>
                @endif
            @endforeach
            
            {{-- If the component doesn't exist/$hasComponent is false. --}}
            @if($hasComponent == false)
                {{-- Pass the build-component="null" so the build-component-item knows to show --}}
                {{-- the add component button and build-component-type="number"/build-id="$build->id" --}}
                {{-- is so the build-component-item knows to pass what component type and to which build --}}
                {{-- should be added when clicking on the add component button. --}}
                <x-build-component-item :build-component="null" :build="$build" :build-component-type-id="1" />
            @endif

            {{-- Reset the $hasComponent to false for the next use. --}}
            <?php $hasComponent = false ?>
        </div>
    </div>



    {{-- Motherboard / Type = 2 --}}
    <div class="d-flex align-items-center">
        <p class="fs-4 w-15p text-end pr-2p mb-0px">@lang('ui.build.motherboard')</p>

        <div class="bb-lgray w-85p pin-20px pbl-10px">
            {{-- Check trough the buildComponents list to see if there is a Motherboard component. If there is --}}
            {{-- show the component and update the $hasComponent to true. --}}
            @foreach($buildComponents as $buildComponent)
                @if($buildComponent->type_id == 2)
                    <x-build-component-item :build-component="$buildComponent" :cheapest-buy-links-combination="$cheapestBuyLinksCombination" />
                    <?php $hasComponent = true ?>
                @endif
            @endforeach
            
            @if($hasComponent == false)
                {{-- Pass the build-component="null" so the build-component-item knows to show --}}
                {{-- the add component button and build-component-type="number"/build-id="$build->id" --}}
                {{-- is so the build-component-item knows to pass what component type and to which build --}}
                {{-- should be added when clicking on the add component button. --}}
                <x-build-component-item :build-component="null" :build="$build" :build-component-type-id="2" />            
            @endif

            <?php $hasComponent = false ?>
        </div>
    </div>



    {{-- RAM / Type = 3 --}}
    <div class="d-flex align-items-center">
        <p class="fs-4 w-15p text-end pr-2p mb-0px">RAM</p>

        <div class="bb-lgray w-85p pin-20px pbl-10px">
            {{-- Check trough the buildComponents list to see if there are RAM components. --}}
            @foreach($buildComponents as $buildComponent)
                @if($buildComponent->type_id == 3)
                    <x-build-component-item :build-component="$buildComponent" :cheapest-buy-links-combination="$cheapestBuyLinksCombination" />
                @endif
            @endforeach
            
            {{-- Pass the build-component="null" so the build-component-item knows to show --}}
            {{-- the add component button and build-component-type="number"/build-id="$build->id" --}}
            {{-- is so the build-component-item knows to pass what component type and to which build --}}
            {{-- should be added when clicking on the add component button. --}}
            <x-build-component-item :build-component="null" :build="$build" :build-component-type-id="3" />
        </div>
    </div>



    {{-- GPU / Type = 4 --}}
    <div class="d-flex align-items-center">
        <p class="fs-4 w-15p text-end pr-2p mb-0px">GPU</p>

        <div class="bb-lgray w-85p pin-20px pbl-10px">
            {{-- Check trough the buildComponents list to see if there is a GPU component. If there is --}}
            {{-- show the component and update the $hasComponent to true. --}}
            @foreach($buildComponents as $buildComponent)
                @if($buildComponent->type_id == 4)
                    <x-build-component-item :build-component="$buildComponent" :cheapest-buy-links-combination="$cheapestBuyLinksCombination" />
                    <?php $hasComponent = true ?>
                @endif
            @endforeach
            
            @if($hasComponent == false)
                {{-- Pass the build-component="null" so the build-component-item knows to show --}}
                {{-- the add component button and build-component-type="number"/build-id="$build->id" --}}
                {{-- is so the build-component-item knows to pass what component type and to which build --}}
                {{-- should be added when clicking on the add component button. --}}
                <x-build-component-item :build-component="null" :build="$build" :build-component-type-id="4" />
            @endif

            <?php $hasComponent = false ?>
        </div>
    </div>



    {{-- Storage / Type = 5 --}}
    <div class="d-flex align-items-center">
        <p class="fs-4 w-15p text-end pr-2p mb-0px">@lang('ui.build.storage')</p>

        <div class="bb-lgray w-85p pin-20px pbl-10px">
            {{-- Check trough the buildComponents list to see if there are Storage components. --}}
            @foreach($buildComponents as $buildComponent)
                @if($buildComponent->type_id == 5)
                    <x-build-component-item :build-component="$buildComponent" :cheapest-buy-links-combination="$cheapestBuyLinksCombination" />
                @endif
            @endforeach
            
            {{-- Pass the build-component="null" so the build-component-item knows to show --}}
            {{-- the add component button and build-component-type="number"/build-id="$build->id" --}}
            {{-- is so the build-component-item knows to pass what component type and to which build --}}
            {{-- should be added when clicking on the add component button. --}}
            <x-build-component-item :build-component="null" :build="$build" :build-component-type-id="5" />
        </div>
    </div>



    {{-- PSU / Type = 6 --}}
    <div class="d-flex align-items-center">
        <p class="fs-4 w-15p text-end pr-2p mb-0px">PSU</p>

        <div class="bb-lgray w-85p pin-20px pbl-10px">
            {{-- Check trough the buildComponents list to see if there is a PSU component. If there is --}}
            {{-- show the component and update the $hasComponent to true. --}}
            @foreach($buildComponents as $buildComponent)
                @if($buildComponent->type_id == 6)
                    <x-build-component-item :build-component="$buildComponent" :cheapest-buy-links-combination="$cheapestBuyLinksCombination" />
                    <?php $hasComponent = true ?>
                @endif
            @endforeach
            
            @if($hasComponent == false)
                {{-- Pass the build-component="null" so the build-component-item knows to show --}}
                {{-- the add component button and build-component-type="number"/build-id="$build->id" --}}
                {{-- is so the build-component-item knows to pass what component type and to which build --}}
                {{-- should be added when clicking on the add component button. --}}
                <x-build-component-item :build-component="null" :build="$build" :build-component-type-id="6" />
            @endif

            <?php $hasComponent = false ?>
        </div>
    </div>



    {{-- Case / Type = 7 --}}
    <div class="d-flex align-items-center">
        <p class="fs-4 w-15p text-end pr-2p mb-0px">@lang('ui.build.case')</p>

        <div class="bb-lgray w-85p pin-20px pbl-10px">
            {{-- Check trough the buildComponents list to see if there is a Case component. If there is --}}
            {{-- show the component and update the $hasComponent to true. --}}
            @foreach($buildComponents as $buildComponent)
                @if($buildComponent->type_id == 7)
                    <x-build-component-item :build-component="$buildComponent" :cheapest-buy-links-combination="$cheapestBuyLinksCombination" />
                    <?php $hasComponent = true ?>
                @endif
            @endforeach
            
            @if($hasComponent == false)
                {{-- Pass the build-component="null" so the build-component-item knows to show --}}
                {{-- the add component button and build-component-type="number"/build-id="$build->id" --}}
                {{-- is so the build-component-item knows to pass what component type and to which build --}}
                {{-- should be added when clicking on the add component button. --}}
                <x-build-component-item :build-component="null" :build="$build" :build-component-type-id="7" />            
            @endif
            <?php $hasComponent = false ?>
        </div>
    </div>



    {{-- Other / Type = 8 --}}
    <div class="d-flex align-items-center">
        <p class="fs-4 w-15p text-end pr-2p mb-0px">@lang('ui.build.other')</p>

        <div class="w-85p pin-20px pbl-10px">
            {{-- Check trough the buildComponents list to see if there are Other components. --}}
            @foreach($buildComponents as $buildComponent)
                @if($buildComponent->type_id == 8)
                    <x-build-component-item :build-component="$buildComponent" :cheapest-buy-links-combination="$cheapestBuyLinksCombination" />
                @endif
            @endforeach
            
            {{-- Pass the build-component="null" so the build-component-item knows to show --}}
            {{-- the add component button and build-component-type="number"/build-id="$build->id" --}}
            {{-- is so the build-component-item knows to pass what component type and to which build --}}
            {{-- should be added when clicking on the add component button. --}}
            <x-build-component-item :build-component="null" :build="$build" :build-component-type-id="8" />        
        </div>
    </div>



</div>