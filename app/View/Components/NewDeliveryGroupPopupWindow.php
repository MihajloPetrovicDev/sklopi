<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NewDeliveryGroupPopupWindow extends Component
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
        return view('components.new-delivery-group-popup-window');
    }
}
