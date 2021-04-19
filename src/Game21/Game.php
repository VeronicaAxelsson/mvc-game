<?php

namespace Veax\Game21;

use Veax\Dice\DiceHand;

use function Mos\Functions\{
    redirectTo,
    renderView,
    sendResponse
};

/**
 * Dice class
 */
class Game
{
    /**
    * @var int $pointsPlayer     Number of won games for player.
    * @var int $pointsComputer   Number of won games for computer
    * @var array $classes            Classes for graphic dice.
    * @var string $message           Message for player.
    */
    private $pointsPlayer = 0;
    private $pointsComputer = 0;
    private $classes = [];
    private $message = "Välj antal tärningar att kasta eller stanna";
    private $data = [];

    /**
    * Start a game.
    *
    * @return void
    */
    public function playGame(): void
    {
        $this->data["header"] = "Game21";
        $this->data["message"] = $this->message;
        $this->data["pointsComputer"] = $this->pointsComputer;
        $this->data["pointsPlayer"] = $this->pointsPlayer;
        $this->data["classes"] = $this->classes;

        if (isset($_SESSION["sumPlayer"])) {
            $this->data["sumPlayer"] = $_SESSION["sumPlayer"];
        }
        if (isset($_SESSION["sumComputer"])) {
            $this->data["sumComputer"] = $_SESSION["sumComputer"];
        }
        // $body = renderView("layout/game21.php", $this->data);
        // sendResponse($body);
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

    /**
    * Roll dies.
    *
    * @return void
    */
    public function rollDice(): void
    {
        if (!isset($_SESSION["sumPlayer"])) {
            $_SESSION["sumPlayer"] = 0;
        }

        $_SESSION["diceHand"] = new DiceHand((int)$_POST["die"]);
        $rolls = $_SESSION["diceHand"]->roll();
        foreach ($rolls as $roll) {
            $_SESSION["sumPlayer"] += $roll;
        }
        /* Om diceHand finns hämtas grafisk representation och läggs i $classes */
        if (isset($_SESSION["diceHand"])) {
            $this->classes = [];
            foreach ($_SESSION["diceHand"]->graphic() as $roll) {
                $this->classes[] = $roll;
            }
        }

        if ($_SESSION["sumPlayer"] >= 21) {
            self::checkWinner();
        }

        // redirectTo("game21");
    }

    /**
    * A game of 21 is played automatically.
    *
    * @return void
    */
    public function playComputer(): void
    {
        if (!isset($_SESSION["sumComputer"])) {
            $_SESSION["sumComputer"] = 0;
        }
        while ($_SESSION["sumComputer"] < 21) {
            $_SESSION["diceHand"] = new DiceHand(1);
            $rolls = $_SESSION["diceHand"]->roll();
            foreach ($rolls as $roll) {
                $_SESSION["sumComputer"] += $roll;
            }
        }
    }

    /**
    * Reset game
    *
    * @return void
    */
    public function resetGame(): void
    {
        $_SESSION["sumPlayer"] = 0;
        $_SESSION["sumComputer"] = 0;
        $this->message = "Välj antal tärningar att kasta eller stanna";

        // redirectTo("game21");
    }

    /**
    * Check who the winner is.
    *
    * @return void
    */
    public function checkWinner(): void
    {
        // var_dump($_SESSION);
        self::playComputer();
        if ($_SESSION["sumComputer"] > 21 && $_SESSION["sumPlayer"] > 21) {
            $this->message = "Båda förlorade";
        } elseif ($_SESSION["sumComputer"] === $_SESSION["sumPlayer"]) {
            $this->message = "Datorn vinner";
            $this->pointsComputer += 1;
        } elseif ($_SESSION["sumComputer"] <= 21 && $_SESSION["sumPlayer"] <= 21) {
            if ($_SESSION["sumComputer"] > $_SESSION["sumPlayer"]) {
                $this->message = "Datorn vinner";
                $this->pointsComputer += 1;
            } else {
                $this->message = "Du vann!!";
                $this->pointsPlayer += 1;
            }
        } elseif ($_SESSION["sumPlayer"] <= 21) {
            $this->message = "Du vann!!";
            $this->pointsPlayer += 1;
        } else {
            $this->message = "Datorn vinner";
            $this->pointsComputer += 1;
        }

        // redirectTo("game21");
    }
}
