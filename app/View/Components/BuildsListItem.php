<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BuildsListItem extends Component
{
    public $buildId;
    public $buildName;

    /**
     * Create a new component instance.
     */
    public function __construct($buildId, $buildName)
    {
        $this->buildId = $buildId;
        $this->buildName = $buildName;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.builds-list-item');
    }
}
