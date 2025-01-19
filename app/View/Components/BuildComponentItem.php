<?php

namespace App\View\Components;

use Closure;
use App\Helpers\EncodeHelper;
use Illuminate\View\Component;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;

class BuildComponentItem extends Component
{
    public $buildComponent;
    public $build;
    public $buildComponentTypeId;
    public $buildComponentBuyLink;

    /**
     * Create a new component instance.
     */
    public function __construct($buildComponent, ?object $build, ?int $buildComponentTypeId, ?Collection $cheapestBuyLinksCombination)
    {
        if($buildComponent) {
            $this->buildComponent = $buildComponent;
            $this->buildComponentBuyLink = $cheapestBuyLinksCombination->where('build_component_id', $buildComponent->id)->first();
        }
        else {
            $this->build = $build;
            $this->buildComponentTypeId = $buildComponentTypeId;
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.build-component-item');
    }
}
