<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuyLink extends Model
{
    public function deliveryGroup() {
        return $this->belongsTo(DeliveryGroup::class, 'delivery_group_id');
    }

    public function buildComponent() {
        return $this->belongsTo(BuildComponent::class, 'build_component_id');
    }
}
