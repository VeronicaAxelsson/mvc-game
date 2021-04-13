<?php

namespace Veax\Yatzy;

use function Mos\Functions\{
    redirectTo,
    renderView,
    sendResponse
};

use Veax\Dice;
/**
 * Dice class
 */
class Yatzy
{
    /**
    * @var int $pointsPlayer     Number of won games for player.
    * @var int $pointsComputer   Number of won games for computer
    * @var array $values            Classes for graphic dice.
    * @var string $message           Message for player.
    */
    private int $pointsPlayer = 0;
    private array $values = [];
    private string $message = "Välj vilka tärningar du viill spara, och tryck sedan på kasta";
    private array $data = [];
    private int $throws = 0;
    private int $round = 1;
    private array $savedValues = [];
    private int $dice = 5;
    private int $sum = 0;
    private int $diceRound = 0;
    private array $score = [];

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

        $diceHand = new \Veax\Dice\DiceHand($this->dice);
        $rolls = $diceHand->roll();
        // $this->round += 1;
        $this->values = [];

        foreach ($diceHand->values() as $roll) {
            $this->values[] = $roll;
        }

        $this->data["values"] = $this->values;
    }

    public function rollDice()
    {
        if ($this->diceRound < 2) {
            $count = 0;
            foreach ($_POST as $key => $value) {
                if ($key !== "submit") {
                    $this->savedValues[] = $value;
                    $count += 1;
                }
            }
        } else {
            $count = 0;
            foreach ($_POST as $key => $value) {
                if ($key !== "submit") {
                    $this->savedValues[] = $value;
                    $count += 1;
                }
            }
            $this->dice -= $count;
            $this->playGame();
            $count = 0;
            foreach ($this->values as $key => $value) {
                $this->savedValues[] = $value;
                $count += 1;
            }
        }

        $this->dice -= $count;
        $this->data["savedValues"] = $this->savedValues;
        $this->diceRound += 1;
    }



    public function showPost()
    {

        $this->data["post"] = $_POST;

    }

    public function sumRound()
    {
        foreach ($this->savedValues as $key => $value) {
            if ($value === (int)$_POST["submit"]) {
                $this->sum += (int)$value;
            }
        }

        $this->data["sum"] = $this->sum;
        $this->score[$_POST["submit"]] =  $this->sum;
        $this->data["score"] = $this->score;

        $_SESSION["yatzySum"] += $this->sum;
    }

    public function newRound()
    {
        if ($this->round >= 6) {
            $this->message = "Game over";
            $this->savedValues = [];
            $this->data["savedValues"] = $this->savedValues;
            $this->data["sum"] = $this->sum;
            $this->score["summa"] = $_SESSION["yatzySum"];

            if ($_SESSION["yatzySum"] >= 63) {
                $this->score["bonus"] = 50;
            }
            $this->data["score"] = $this->score;
            return;
        }
        $this->sum = 0;
        $this->dice = 5;
        $this->diceRound = 0;
        $this->savedValues = [];
        $this->data["savedValues"] = $this->savedValues;
        $this->data["sum"] = $this->sum;
        $this->round += 1;
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
