<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class UserAccess
 */
class UserAccess extends Model
{
    public const DAYS_LINK_EXPIRE = 7;

    public $timestamps = false;

    protected $table = 'user_access';
    protected $casts = [
        'expires_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $fillable = [
        'hash',
        'expires_at'
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'hash';
    }

    /**
     * @return bool
     */
    public function isExpired(): bool
    {
        return $this->expires_at->lt(Carbon::now());
    }
}
