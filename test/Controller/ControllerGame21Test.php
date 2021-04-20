<?php

declare(strict_types=1);

namespace Veax\Controller;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Veax\Game21\Game;

/**
 * Test cases for the controller Game21.
 */
class ControllerGame21Test extends TestCase
{
    /**
     * Test up with creating controller class assert.
     */
    private $controller;
    public function setUp(): void
    {
        session_start();
        $this->controller = new Game21();
        $this->assertInstanceOf("\Veax\Controller\Game21", $this->controller);
    }

    /**
     * Check that the index action returns a response.
     * @runInSeparateProcess
     */
    public function testControllerIndexAction()
    {
        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $this->controller->index();
        $this->assertInstanceOf($exp, $res);
    }

    /**
     * Check that the roll action returns a response.
     * @runInSeparateProcess
     */
    public function testControllerRollAction()
    {
        $_SESSION["game"] = new Game();
        $_POST["die"] = 1;
        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $this->controller->roll();
        $this->assertInstanceOf($exp, $res);
    }

    /**
     * Check that the end action returns a response.
     * @runInSeparateProcess
     */
    public function testControllerEndAction()
    {
        $_SESSION["game"] = new Game();
        $_SESSION["sumPlayer"] = 0;
        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $this->controller->end();
        $this->assertInstanceOf($exp, $res);
    }

    /**
     * Check that the reset action returns a response.
     * @runInSeparateProcess
     */
    public function testControllerResetAction()
    {
        $_SESSION["game"] = new Game();
        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $this->controller->reset();
        $this->assertInstanceOf($exp, $res);
    }

    /**
     * Check that the newRound action returns a response.
     * @runInSeparateProcess
     */
    public function testControllerNewRoundAction()
    {
        $_SESSION["game"] = new Game();
        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $this->controller->newRound();
        $this->assertInstanceOf($exp, $res);
    }
}
