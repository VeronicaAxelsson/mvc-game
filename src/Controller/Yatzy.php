<?php

declare(strict_types=1);

namespace Veax\Controller;

use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

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
            $_SESSION["yatzy"] = new \Veax\Yatzy\Yatzy();
        }
        $_SESSION["yatzy"]->playGame();

        $data = $_SESSION["yatzy"]->getData();

        $body = renderView("layout/yatzy.php", $data);

        // var_dump($_POST);

        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }

    public function throw(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();

        $_SESSION["yatzy"]->showPost();
        $_SESSION["yatzy"]->rollDice();

        return (new Response())
            ->withStatus(301)
            ->withHeader("Location", url("/yatzy"));
    }

    public function newGame(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();

        $_SESSION["yatzy"] = new \Veax\Yatzy\Yatzy();
        $_SESSION["yatzySum"] = 0;

        return (new Response())
            ->withStatus(301)
            ->withHeader("Location", url("/yatzy"));
    }

    public function newRound(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();
        $_SESSION["yatzy"]->sumRound();
        $_SESSION["yatzy"]->newRound();

        return (new Response())
            ->withStatus(301)
            ->withHeader("Location", url("/yatzy"));
    }
}
