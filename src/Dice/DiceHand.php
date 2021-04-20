<?php

namespace Veax\Dice;

/**
 * Dice class
 */
class DiceHand
{
    /**
    * @var array $rolls     The value of the rolls.
    * @var array $dice     Array with dies.
    * @var array $classes   Array with graphic representation of rolls.
    * @var int $sum     Sum of the rolls.
    */

    private $rolls = [];
    private $dice;
    private $classes = [];
    private $sum = null;

    /**
    * Constructor to initiate the dicehand with a number of dice.
    *
    * @param int $dice Number of dice to create, defaults to five.
    */
    public function __construct(int $dice = 5)
    {
        $this->dice = [];

        for ($i = 0; $i < $dice; $i++) {
            $this->dice[] = new GraphicalDice();
        }
    }
    /**
    * Roll dice.
    *
    * @return array
    */
    public function roll(): array
    {
        foreach ($this->dice as $die) {
            $this->rolls[] = $die->rollDice();
            $this->classes[] = $die->graphic();
        }

        return $this->rolls;
    }

    /*
    * Get the rolls.
    *
    * @return array with values of roles.
    */
    public function values(): array
    {
        return $this->rolls;
    }

    /**
    * Get classes of dice.
    *
    * @return array with classes for die.
    */
    public function graphic(): array
    {
        return $this->classes;
    }

    /**
    * Get dice array.
    *
    * @return array with dice.
    */
    public function dice(): array
    {
        return $this->dice;
    }

    /**
    * Get sum of roll.
    *
    * @return int with sum of roles.
    */
    public function sum(): int
    {
        foreach ($this->rolls as $roll) {
            $this->sum += $roll;
        }
        return $this->sum;
    }

    /**
    * Get average of roll.
    *
    * @return int with sum of roles.
    */
    public function average(): int
    {
        return $this->sum / 5;
    }
}
