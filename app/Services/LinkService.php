<?php

namespace App\Services;

use Illuminate\Support\Str;

/**
 * Class LinkService
 */
class LinkService
{
    /**
     * @return string
     */
    public function generateHash(): string
    {
        return Str::random(40);
    }
}
