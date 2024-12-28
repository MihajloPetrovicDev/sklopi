<?php $hasComponent = false ?>

<div class="mx-auto w-80p section-1 mt-5 pbl-20px mb-5">
    <!-- CPU -->
    <div class="d-flex align-items-center">
        <p class="fs-4 w-15p text-end pr-2p mb-0px">CPU</p>

        <div class="bb-lgray w-85p pin-20px pbl-10px">
            @foreach($buildComponents as $buildComponent)
                @if($buildComponent->type_id == 1)
                    <x-build-component-item :build-component="$buildComponent" />
                    <?php $hasComponent = true ?>
                @endif
            @endforeach
            
            @if($hasComponent == false)
                <x-build-component-item :build-component="null" />
            @endif

            <?php $hasComponent = false ?>
        </div>
    </div>


    <!-- Motherboard -->
    <div class="d-flex align-items-center">
        <p class="fs-4 w-15p text-end pr-2p mb-0px">@lang('ui.build.motherboard')</p>

        <div class="bb-lgray w-85p pin-20px pbl-10px">
            @foreach($buildComponents as $buildComponent)
                @if($buildComponent->type_id == 2)
                    <x-build-component-item :build-component="$buildComponent" />
                    <?php $hasComponent = true ?>
                @endif
            @endforeach
            
            @if($hasComponent == false)
                <x-build-component-item :build-component="null" />
            @endif

            <?php $hasComponent = false ?>
        </div>
    </div>


    <!-- RAM -->
    <div class="d-flex align-items-center">
        <p class="fs-4 w-15p text-end pr-2p mb-0px">RAM</p>

        <div class="bb-lgray w-85p pin-20px pbl-10px">
            @foreach($buildComponents as $buildComponent)
                @if($buildComponent->type_id == 3)
                    <x-build-component-item :build-component="$buildComponent" />
                @endif
            @endforeach
            
            <x-build-component-item :build-component="null" />
        </div>
    </div>


    <!-- GPU -->
    <div class="d-flex align-items-center">
        <p class="fs-4 w-15p text-end pr-2p mb-0px">GPU</p>

        <div class="bb-lgray w-85p pin-20px pbl-10px">
            @foreach($buildComponents as $buildComponent)
                @if($buildComponent->type_id == 4)
                    <x-build-component-item :build-component="$buildComponent" />
                    <?php $hasComponent = true ?>
                @endif
            @endforeach
            
            @if($hasComponent == false)
                <x-build-component-item :build-component="null" />
            @endif

            <?php $hasComponent = false ?>
        </div>
    </div>


    <!-- Storage -->
    <div class="d-flex align-items-center">
        <p class="fs-4 w-15p text-end pr-2p mb-0px">@lang('ui.build.storage')</p>

        <div class="bb-lgray w-85p pin-20px pbl-10px">
            @foreach($buildComponents as $buildComponent)
                @if($buildComponent->type_id == 5)
                    <x-build-component-item :build-component="$buildComponent" />
                @endif
            @endforeach
            
            <x-build-component-item :build-component="null" />
        </div>
    </div>


    <!-- PSU -->
    <div class="d-flex align-items-center">
        <p class="fs-4 w-15p text-end pr-2p mb-0px">PSU</p>

        <div class="bb-lgray w-85p pin-20px pbl-10px">
            @foreach($buildComponents as $buildComponent)
                @if($buildComponent->type_id == 6)
                    <x-build-component-item :build-component="$buildComponent" />
                    <?php $hasComponent = true ?>
                @endif
            @endforeach
            
            @if($hasComponent == false)
                <x-build-component-item :build-component="null" />
            @endif

            <?php $hasComponent = false ?>
        </div>
    </div>


    <!-- Case -->
    <div class="d-flex align-items-center">
        <p class="fs-4 w-15p text-end pr-2p mb-0px">@lang('ui.build.case')</p>

        <div class="bb-lgray w-85p pin-20px pbl-10px">
            @foreach($buildComponents as $buildComponent)
                @if($buildComponent->type_id == 7)
                    <x-build-component-item :build-component="$buildComponent" />
                    <?php $hasComponent = true ?>
                @endif
            @endforeach
            
            @if($hasComponent == false)
                <x-build-component-item :build-component="null" />
            @endif

            <?php $hasComponent = false ?>
        </div>
    </div>


    <!-- Other -->
    <div class="d-flex align-items-center">
        <p class="fs-4 w-15p text-end pr-2p mb-0px">@lang('ui.build.other')</p>

        <div class="w-85p pin-20px pbl-10px">
            @foreach($buildComponents as $buildComponent)
                @if($buildComponent->type_id == 8)
                    <x-build-component-item :build-component="$buildComponent" />
                @endif
            @endforeach
            
            <x-build-component-item :build-component="null" />
        </div>
    </div>
</div>