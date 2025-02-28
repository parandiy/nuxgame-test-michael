<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class User
 */
class User extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'phone'
    ];

    /**
     * @return HasMany
     */
    public function accesses(): HasMany
    {
        return $this->hasMany(UserAccess::class);
    }

    /**
     * @return HasMany
     */
    public function games(): HasMany
    {
        return $this->hasMany(UserGame::class);
    }

    /**
     * @return string|null
     */
    public function getValidAccessHash()
    {
        return $this->accesses()->whereNowOrFuture('expires_at')->first()->hash ?? null;
    }
}
