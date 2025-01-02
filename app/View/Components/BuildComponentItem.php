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
    public $encodedBuildId;

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
            $this->encodedBuildId = EncodeHelper::encode($this->build->id);
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
