<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuildComponent extends Model
{
    public function build() {
        return $this->belongsTo(Build::class, 'build_id');
    }
}
