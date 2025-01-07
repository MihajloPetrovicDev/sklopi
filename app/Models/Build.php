<?php

namespace App\Models;

use App\Helpers\EncodeHelper;
use Illuminate\Database\Eloquent\Model;

class Build extends Model
{
    public function getEncodedIdAttribute() {
        $encodedId = EncodeHelper::encode($this->id);

        return $encodedId;
    }
}
