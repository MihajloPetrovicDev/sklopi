<?php

namespace App\View\Components;

use App\Helpers\EncodeHelper;
use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class BuildComponentItem extends Component
{
    public $buildComponent;
    public $build;
    public $buildComponentTypeId;

    /**
     * Create a new component instance.
     */
    public function __construct($buildComponent, ?object $build, ?int $buildComponentTypeId)
    {
        if($buildComponent) {
            $this->buildComponent = $buildComponent;
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
