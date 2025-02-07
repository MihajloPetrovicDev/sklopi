<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordResetToken extends Model
{
    public $timestamps = true;
    protected $primaryKey = 'token';
    public $incrementing = false;
    protected $keyType = 'string';

    const UPDATED_AT = null;
}
