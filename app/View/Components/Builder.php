<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Builder extends Component
{
    public $build;
    public $buildComponents;

    /**
     * Create a new component instance.
     */
    public function __construct($build, $buildComponents)
    {
        $this->build = $build;
        $this->buildComponents = $buildComponents;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.builder');
    }
}
