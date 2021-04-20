<?php

declare(strict_types=1);

namespace Veax\Controller;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Veax\Yatzy\Game;

/**
 * Test cases for the controller Game21.
 */
class ControllerYatzyTest extends TestCase
{
    /**
     * Test up with creating controller class assert.
     */
    private $controller;
    public function setUp(): void
    {
        session_start();
        $this->controller = new Yatzy();
        $this->assertInstanceOf("\Veax\Controller\Yatzy", $this->controller);
    }

    /**
     * Check that the controller returns a response.
     * @runInSeparateProcess
     */
    public function testControllerIndexAction()
    {
        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $this->controller->index();
        $this->assertInstanceOf($exp, $res);
    }

    /**
    *  @runInSeparateProcess
    */
    public function testControllerThrowAction()
    {
        $_SESSION["yatzy"] = new Game();
        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $this->controller->throw();
        $this->assertInstanceOf($exp, $res);
    }

    /**
    *  @runInSeparateProcess
    */
    public function testControllerNewGameAction()
    {
        $_SESSION["yatzy"] = new Game();
        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $this->controller->newGame();
        $this->assertInstanceOf($exp, $res);
        $this->assertEquals(0, $_SESSION["yatzySum"]);
    }

    /**
    *  @runInSeparateProcess
    */
    public function testControllerNewRoundAction()
    {
        $_SESSION["yatzy"] = new Game();
        $_POST["diceValue"] = 1;
        $_SESSION["yatzySum"] = 0;
        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $this->controller->newRound();
        $this->assertInstanceOf($exp, $res);
    }
}
