<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Builder extends Component
{
    public $build;
    public $buildComponents;
    public $cheapestBuyLinksCombination;

    /**
     * Create a new component instance.
     */
    public function __construct($build, $buildComponents, $cheapestBuyLinksCombination)
    {
        $this->build = $build;
        $this->buildComponents = $buildComponents;
        $this->cheapestBuyLinksCombination = $cheapestBuyLinksCombination;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.builder');
    }
}
