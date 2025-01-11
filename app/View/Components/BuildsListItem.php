<?php

namespace App\View\Components;

use App\Helpers\EncodeHelper;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BuildsListItem extends Component
{
    public $build;

    /**
     * Create a new component instance.
     */
    public function __construct($build)
    {
        $this->build = $build;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.builds-list-item');
    }
}
