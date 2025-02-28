<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserAccess;

/**
 * Class UserService
 */
class UserService
{
    public function __construct(private readonly LinkService $linkService)
    {
    }

    /**
     * @param  string  $name
     * @param  string  $phone
     * @return User
     */
    public function createUserWithAccess(string $name, string $phone): User
    {
        $user = User::create(
            [
                'name' => $name,
                'phone' => $phone,
            ]
        );

        $user->accesses()->create([
            'hash' => $this->linkService->generateHash(),
            'expires_at' => now()->addDays(UserAccess::DAYS_LINK_EXPIRE),
        ]);

        return $user;
    }

    /**
     * @param  UserAccess  $userAccess
     * @return UserAccess
     */
    public function regenerateLink(UserAccess $userAccess): UserAccess
    {
        $userAccess->update(['expires_at' => now()]);

        $newUserAccess = $userAccess->user->accesses()->create([
            'hash' => $this->linkService->generateHash(),
            'expires_at' => now()->addDays(UserAccess::DAYS_LINK_EXPIRE),
        ]);

        return $newUserAccess;
    }
}
