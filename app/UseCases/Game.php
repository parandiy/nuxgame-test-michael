<?php

declare(strict_types=1);

namespace App\UseCases;

/**
 * Class Game
 */
class Game
{
    public const MIN_NUMBER = 1;
    public const MAX_NUMBER = 1000;
    public const WIN = 'win';
    public const LOSE = 'lose';

    /** @var int */
    private int $number;

    /** @var string */
    private string $result;

    /** @var float|int */
    private float|int $amount = 0;

    /**
     *
     */
    public function __construct()
    {
        $this->number = rand(self::MIN_NUMBER, self::MAX_NUMBER);
        $this->result = $this->number % 2 === 0 ? self::WIN : self::LOSE;

        if ($this->result === self::WIN) {
            $this->calculateAmount();
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'number' => $this->number,
            'result' => $this->result,
            'amount' => $this->amount,
        ];
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return 'Random number is: '.$this->number.'. Result: '.strtoupper($this->result).'. Amount: '.$this->amount.'.';
    }

    /**
     * @return string
     */
    public function getResult(): string
    {
        return $this->result;
    }

    /**
     * @return void
     */
    private function calculateAmount(): void
    {
        if ($this->number > 900) {
            $amount = 0.7 * $this->number;
        } elseif ($this->number > 600) {
            $amount = 0.5 * $this->number;
        } elseif ($this->number > 300) {
            $amount = 0.3 * $this->number;
        } else {
            $amount = 0.1 * $this->number;
        }

        $this->amount = $amount;
    }
}
