<?php

namespace App\Helpers;

use Hashids\Hashids;

class EncodeHelper
{
    public static function encode($id)
    {
        $hashids = new Hashids('', 15);
        return $hashids->encode($id);
    }

    public static function decode($encodedId)
    {
        $hashids = new Hashids('', 15);
        $decoded = $hashids->decode($encodedId);
        return $decoded[0] ?? null;
    }
}
