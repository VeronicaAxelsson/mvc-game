<?php

namespace Veax\Dice;

/**
 * Dice class
 */
class GraphicalDice extends Dice
{
    /**
     * @var integer SIDES Number of sides of the Dice.
     */
     /* Stor bokstav för konstanter följer kodstandard enligt PSR-1
     Till konstanter refererar man till self, för man refererar Till
     klassen och inte enskilt objekt*/
    const SIDES = 6;
    /**
     * Constructor to initiate the dice with six number of sides.
     */
    public function __construct()
    {
        /* Vi vill alltid att det ska vara 6 sidor i den grafiska varianten
        parent är en referens till basklassen. den kan användas för att
        specifikt kalla på de delar som ligger inuti basklassen, även om man i
        nuvarande klass har gjort en överlagring på dem, som i detta fallet
        med konstruktorn.*/
        parent::__construct(self::SIDES);
    }

    /**
     * Get a graphic value of the last rolled dice.
     *
     * @return string as graphical representation of last rolled dice.
     */
    public function graphic()
    {
        return "dice-" . $this->getLastRoll();
    }
}
