<?php

namespace Veax\Yatzy;

use Veax\Dice\DiceHand;

/**
 * Game class for yatzy
 */
class Game
{
    /**
    * @var string $message          Message for player.
    * @var array $values            The values of the thrown dice.
    * @var array $data              Array with data to be passed when rendering view.
    * @var array $savedValues       Values of the choosen dice for each round.
    * @var array $score             Scores for each kind of dice, total score and bonus.
    * @var int $throws              Number of throws that been thrown during one round.
    * @var int $round               Number of rounds that been played during one game.
    * @var int $dice                Number of dice to be passed to DiceHand.
    */
    private $message = "Tryck på kasta för att kasta tärningarna!";
    private $values = [];
    private $data = [];
    private $savedValues = [];
    private $score = [];
    private $throws = 0;
    private $round = 1;
    private $dice = 5;

    /**
    * Start a game.
    *
    * @return void
    */
    public function playGame(): void
    {
        if (!isset($_SESSION["yatzySum"])) {
            $_SESSION["yatzySum"] = 0;
        }

        $this->data["header"] = "Yatzy";
        $this->data["message"] = $this->message;
    }

    /**
    * Roll dice.
    *
    * @return void
    */
    public function rollDice(): void
    {
        $diceHand = new DiceHand($this->dice);
        $diceHand->roll();
        $this->values = [];

        foreach ($diceHand->values() as $roll) {
            $this->values[] = $roll;
        }

        $this->data["values"] = $this->values;
    }

    /**
    * Moves dice from values to saved values
    *
    * @return void
    */
    public function moveDice(): void
    {
            $count = 0;
        foreach ($_POST as $key => $value) {
            if ($key !== "throw") {
                $this->savedValues[] = $value;
                $count += 1;
            }
        }
            $this->message = "Välj vilka tärningar du vill behålla, och kasta igen.";


        if ($this->throws > 1) {
            $this->message = "Välj vilka tärningar du vill räkna genom att trycka på en ruta i tabellen.";
            $this->dice -= $count;
            $this->rollDice();
            $count = 0;
            foreach ($this->values as $key => $value) {
                $this->savedValues[] = $value;
                $count += 1;
            }
        }

            $this->dice -= $count;
            $this->data["savedValues"] = $this->savedValues;
            $this->data["count"] = $count;
            $this->data["dice"] = $this->dice;
            $this->throws += 1;
    }

    // public function showPost()
    // {
    //     $this->data["post"] = $_POST;
    // }

    /**
    * Sum values of choosen dice-value, sent via POST-form
    *
    * @return void
    */
    public function sumRound(): void
    {
        $sum = 0;
        foreach ($this->savedValues as $value) {
            if ((int)$value === (int)$_POST["diceValue"]) {
                $sum += (int)$value;
            }
        }

        //set score for the choosen diceValue to sum
        $this->score[$_POST["diceValue"]] = $sum;
        $this->data["score"] = $this->score;

        $_SESSION["yatzySum"] += $sum;
    }

    /**
    * Start new round
    *
    * @return void
    */
    public function newRound(): void
    {
        if ($this->round >= 6) {
            $this->message = "Game over";
            $this->savedValues = [];
            $this->data["savedValues"] = $this->savedValues;
            $this->score["summa"] = $_SESSION["yatzySum"];

            if ($_SESSION["yatzySum"] >= 63) {
                $this->score["bonus"] = 50;
            }

            $this->data["score"] = $this->score;
            return;
        }

        $this->dice = 5;
        $this->throws = 0;
        $this->savedValues = [];
        $this->data["savedValues"] = $this->savedValues;
        $this->round += 1;
        $this->message = "Tryck på kasta för att kasta tärningarna!";
    }

    /**
    * Return data array
    *
    * @return array
    */
    public function getData(): array
    {
        return $this->data;
    }
}
