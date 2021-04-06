<?php

namespace Veax\Dice;

/**
 * Dice class
 */
class DiceHand
{
    /**
    * @var integer $roll    The value of latest roll.
    */

    private array $rolls = [];
    private array $dices;
    private array $classes = [];
    private ?int $sum = null;
    private ?int $average = null;

    /**
    * Constructor to initiate the dicehand with a number of dices.
    *
    * @param int $dices Number of dices to create, defaults to five.
    */
    public function __construct(int $dices = 5)
    {
        $this->dices = [];

        for ($i = 0; $i < $dices; $i++) {
            $this->dices[] = new GraphicalDice();
        }
    }
    /**
    * Roll dice.
    *
    * @return array
    */
    public function roll(): array
    {
        foreach ($this->dices as $dice) {
            $this->rolls[] = $dice->rollDice();
            $this->classes[] = $dice->graphic();
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
    * Get classes of die.
    *
    * @return array with classes for die.
    */
    public function graphic(): array
    {
        return $this->classes;
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
