<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\UserAccess;
use App\Services\GameService;
use App\Services\UserService;
use App\UseCases\Game;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Class DashboardController
 */
class DashboardController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view('dashboard.index');
    }

    /**
     * @param  UserAccess  $userAccess
     * @param  GameService  $gameService
     * @return RedirectResponse
     */
    public function play(UserAccess $userAccess, GameService $gameService): RedirectResponse
    {
        $game = $gameService->play();

        $userAccess->user->games()->create($game->toArray());

        return redirect()->route('dashboard.index', ['hash' => $userAccess->hash])->with(
            'message',
            [
                'type' => ($game->getResult() === Game::WIN) ? 'success' : 'danger',
                'text' => $game->getMessage()
            ]
        );
    }


    /**
     * @param  UserAccess  $userAccess
     * @return View
     */
    public function history(UserAccess $userAccess): View
    {
        return view(
            'dashboard.history',
            [
                'items' => $userAccess->user->games()->orderBy('created_at', 'desc')->limit(3)->get()
            ]
        );
    }

    /**
     * @param  UserAccess  $userAccess
     * @param  UserService  $userService
     * @return RedirectResponse
     */
    public function regenerateLink(UserAccess $userAccess, UserService $userService): RedirectResponse
    {
        $newUserAccess = $userService->regenerateLink($userAccess);

        return redirect()->route('dashboard.index', ['hash' => $newUserAccess->hash])->with(
            'message',
            [
                'type' => 'success',
                'text' => 'Link regenerated successfully'
            ]
        );
    }

    /**
     * @param  UserAccess  $userAccess
     * @return RedirectResponse
     */
    public function deactivateLink(UserAccess $userAccess): RedirectResponse
    {
        $userAccess->update(['expires_at' => now()]);

        return redirect()->route('dashboard.expired');
    }

    /**
     * @return View
     */
    public function expired(): View
    {
        return view('dashboard.expired');
    }
}
