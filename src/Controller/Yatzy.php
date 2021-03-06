<?php

declare(strict_types=1);

namespace Veax\Controller;

use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Veax\Yatzy\Game;

use function Mos\Functions\{
    renderView,
    url
};

/**
 * Controller for the index route.
 */
class Yatzy
{
    public function index(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();

        if (!isset($_SESSION["yatzy"])) {
            $_SESSION["yatzy"] = new Game();
        }
        $_SESSION["yatzy"]->playGame();

        $data = $_SESSION["yatzy"]->getData();

        $body = renderView("layout/yatzy.php", $data);

        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }

    public function throw(): ResponseInterface
    {
        $_SESSION["yatzy"]->moveDice();
        // $_SESSION["yatzy"]->showPost();
        // $_SESSION["yatzy"]->rollDice();

        return (new Response())
            ->withStatus(301)
            ->withHeader("Location", url("/yatzy"));
    }

    public function newGame(): ResponseInterface
    {
        $_SESSION["yatzy"] = new Game();
        $_SESSION["yatzySum"] = 0;

        return (new Response())
            ->withStatus(301)
            ->withHeader("Location", url("/yatzy"));
    }

    public function newRound(): ResponseInterface
    {
        $_SESSION["yatzy"]->sumRound();
        $_SESSION["yatzy"]->newRound();

        return (new Response())
            ->withStatus(301)
            ->withHeader("Location", url("/yatzy"));
    }
}
