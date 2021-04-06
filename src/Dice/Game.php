<?php

namespace Veax\Dice;

use function Mos\Functions\{
    destroySession,
    redirectTo,
    renderView,
    renderTwigView,
    sendResponse,
    url
};

/**
 * Dice class
 */
class Game
{
    private int $pointsPlayer = 0;
    private int $pointsComputer = 0;
    private array $classes = [];
    private string $message = "Välj antal tärningar att kasta eller stanna";


    public function playGame(): void
    {
        $data["header"] = "Game21";
        $data["message"] = $this->message;
        $data["pointsComputer"] = $this->pointsComputer;
        $data["pointsPlayer"] = $this->pointsPlayer;
        $data["classes"] = $this->classes;

        if (isset($_SESSION["sumPlayer"])) {
            $data["sumPlayer"] = $_SESSION["sumPlayer"];
        }
        if (isset($_SESSION["sumComputer"])) {
            $data["sumComputer"] = $_SESSION["sumComputer"];
        }
        $body = renderView("layout/game21.php", $data);
        sendResponse($body);
    }

    public function rollDice(): void
    {
        if (!isset($_SESSION["sumPlayer"])) {
            $_SESSION["sumPlayer"] = 0;
        }

        $_SESSION["diceHand"] = new \Veax\Dice\DiceHand((int)$_POST["die"]);
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
    }

    public function playComputer(): void
    {
        if (!isset($_SESSION["sumComputer"])) {
            $_SESSION["sumComputer"] = 0;
        }
        while ($_SESSION["sumComputer"] < 21) {
            $_SESSION["diceHand"] = new \Veax\Dice\DiceHand(1);
            $rolls = $_SESSION["diceHand"]->roll();
            foreach ($rolls as $roll) {
                $_SESSION["sumComputer"] += $roll;
            }
        }
    }

    public function resetGame(): void
    {
        $_SESSION["sumPlayer"] = 0;
        $_SESSION["sumComputer"] = 0;
        $this->message = "Välj antal tärningar att kasta eller stanna";
    }

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
    }
}
