<?php

namespace App\Models;

use App\Helpers\EncodeHelper;
use Illuminate\Database\Eloquent\Model;

class BuildComponent extends Model
{
    public function getEncodedIdAttribute() {
        $encodedId = EncodeHelper::encode($this->id);

        return $encodedId;
    }

    public function build() {
        return $this->belongsTo(Build::class, 'build_id');
    }

    public function buyLinks() {
        return $this->hasMany(BuyLink::class, 'build_component_id');
    }
}
