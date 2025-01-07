<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BuyLinksListItem extends Component
{
    public $buyLink;
    public $buildDeliveryGroups;


    /**
     * Create a new component instance.
     */
    public function __construct($buyLink, $buildDeliveryGroups)
    {
        $this->buyLink = $buyLink;
        $this->buildDeliveryGroups = $buildDeliveryGroups;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.buy-links-list-item');
    }
}
