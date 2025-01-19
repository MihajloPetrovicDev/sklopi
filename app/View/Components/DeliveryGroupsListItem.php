<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DeliveryGroupsListItem extends Component
{
    public $deliveryGroup;
    
    /**
     * Create a new component instance.
     */
    public function __construct($deliveryGroup)
    {
        $this->deliveryGroup = $deliveryGroup;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.delivery-groups-list-item');
    }
}
