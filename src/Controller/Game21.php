<?php

declare(strict_types=1);

namespace Veax\Controller;

use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Veax\Game21\Game;

use function Mos\Functions\{
    renderView,
    url
};

/**
 * Controller for the index route.
 */
class Game21
{
    public function index(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();

        if (!isset($_SESSION["game"])) {
            $_SESSION["game"] = new Game();
        }
        $_SESSION["game"]->playGame();

        $data = $_SESSION["game"]->getData();

        $body = renderView("layout/game21.php", $data);

        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }

    public function roll(): ResponseInterface
    {
        $_SESSION["game"]->rollDice();

        return (new Response())
            ->withStatus(301)
            ->withHeader("Location", url("/game21"));
    }

    public function end(): ResponseInterface
    {
        $_SESSION["game"]->playComputer();
        $_SESSION["game"]->checkWinner();

        return (new Response())
            ->withStatus(301)
            ->withHeader("Location", url("/game21"));
    }

    public function reset(): ResponseInterface
    {
        $_SESSION["game"] = new Game();
        $_SESSION["game"]->resetGame();

        return (new Response())
            ->withStatus(301)
            ->withHeader("Location", url("/game21"));
    }

    public function newRound(): ResponseInterface
    {
        $_SESSION["game"]->resetGame();

        return (new Response())
            ->withStatus(301)
            ->withHeader("Location", url("/game21"));
    }
}
