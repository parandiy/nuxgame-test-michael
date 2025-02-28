<?php

namespace App\Services;

use App\UseCases\Game;

/**
 * Class GameService
 */
class GameService
{
    /**
     * @return Game
     */
    public function play(): Game
    {
        return new Game();
    }
}
