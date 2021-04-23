<?php

declare(strict_types=1);

namespace Veax\Controller;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Veax\Yatzy\Game;
use ReflectionClass;

/**
 * Test cases for the controller Game21.
 */
class ControllerYatzyTest extends TestCase
{
    private $controller;
    /**
     * Test setUp with creating controller class and assert.
     */
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
    * Check that the throw action returns a response and right header.
    */
    public function testControllerThrowAction()
    {
        $_SESSION["yatzy"] = new Game();
        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $this->controller->throw();
        $this->assertInstanceOf($exp, $res);

        $reflector = new ReflectionClass($res);
        $reflectorProperty = $reflector->getProperty("headers");
        $reflectorProperty->setAccessible(true);
        $header = $reflectorProperty->getValue($res)['Location'][0];
        $this->assertStringEndsWith("/yatzy", $header);
    }

    /**
    *  @runInSeparateProcess
    * Check that the newGame action returns a response and right header.
    */
    public function testControllerNewGameAction()
    {
        $_SESSION["yatzy"] = new Game();
        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $this->controller->newGame();
        $this->assertInstanceOf($exp, $res);
        $this->assertEquals(0, $_SESSION["yatzySum"]);

        $reflector = new ReflectionClass($res);
        $reflectorProperty = $reflector->getProperty("headers");
        $reflectorProperty->setAccessible(true);
        $header = $reflectorProperty->getValue($res)['Location'][0];
        $this->assertStringEndsWith("/yatzy", $header);
    }

    /**
    *  @runInSeparateProcess
    * Check that the newGame action returns a response and right header.
    */
    public function testControllerNewRoundAction()
    {
        $_SESSION["yatzy"] = new Game();
        $_POST["diceValue"] = 1;
        $_SESSION["yatzySum"] = 0;
        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $this->controller->newRound();
        $this->assertInstanceOf($exp, $res);

        $reflector = new ReflectionClass($res);
        $reflectorProperty = $reflector->getProperty("headers");
        $reflectorProperty->setAccessible(true);
        $header = $reflectorProperty->getValue($res)['Location'][0];
        $this->assertStringEndsWith("/yatzy", $header);
    }
}
