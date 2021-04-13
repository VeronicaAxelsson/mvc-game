<?php

namespace Veax\Dice;

/**
 * Dice class
 */
class Dice
{
    /**
    * @var int $roll    The value of latest roll.
    * @var int $sides   Number of sides of the dice
    */
    private $roll = null;
    private $sides;

    /**
    * Constructor to initiate the dice with a number of sides.
    *
    * @param int $sides
    */
    public function __construct(int $sides = 6)
    {
        $this->sides  = $sides;
    }

    /**
    * Roll dice.
    *
    * @return int
    */
    public function rollDice(): int
    {
        $this->roll = rand(1, $this->sides);

        return $this->roll;
    }

    /**
    * Get the latest roll.
    *
    * @return int as result of latest roll.
    */
    public function getLastRoll(): ?int
    {
        return $this->roll;
    }
}
