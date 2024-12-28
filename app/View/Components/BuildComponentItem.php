<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class BuildComponentItem extends Component
{
    public $buildComponent;

    /**
     * Create a new component instance.
     */
    public function __construct($buildComponent)
    {
        if($buildComponent) {
            $this->buildComponent = $buildComponent;
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
