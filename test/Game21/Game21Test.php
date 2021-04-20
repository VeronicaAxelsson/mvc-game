<?php

namespace Veax\Game21;

use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * Test cases for class Game for Game21
 */
class Game21Test extends TestCase
{
    private $game21;

    protected function setUp(): void
    {
        $this->game21 = new Game();
        $this->assertInstanceOf("\Veax\Game21\Game", $this->game21);
    }

    public function testGameSetUpWithPlayGame()
    {
        $_SESSION["sumPlayer"] = 0;
        $_SESSION["sumComputer"] = 0;

        $this->game21->playGame();
        $res = $this->game21->getData();

        $this->assertArrayHasKey("header", $res);
        $this->assertArrayHasKey("message", $res);
        $this->assertArrayHasKey("pointsComputer", $res);
        $this->assertArrayHasKey("pointsPlayer", $res);
        $this->assertArrayHasKey("classes", $res);
        $this->assertEquals($res["sumPlayer"], $_SESSION["sumPlayer"]);
        $this->assertEquals($res["sumComputer"], $_SESSION["sumComputer"]);
    }

    public function testRollDice()
    {
        $_POST = ["die" => 2];
        $_SESSION["sumPlayer"] = null;
        $this->game21->rollDice();

        $this->assertArrayHasKey("sumPlayer", $_SESSION);
    }

    public function testRollDicePlayerOver21()
    {
        $reflector = new ReflectionClass($this->game21);
        $reflectorProperty = $reflector->getProperty("message");
        $reflectorProperty->setAccessible(true);

        $_POST = ["die" => 2];
        $_SESSION["sumPlayer"] = 21;
        $this->game21->rollDice();
        $res = $reflectorProperty->getValue($this->game21);

        $this->assertNotEquals("Välj antal tärningar att kasta eller stanna", $res);
        $this->assertLessThanOrEqual(26, $_SESSION["sumComputer"]);
        $this->assertGreaterThanOrEqual(21, $_SESSION["sumComputer"]);
    }

    public function testResetGame()
    {
        $this->game21->resetGame();
        $this->assertEquals(0, $_SESSION["sumComputer"]);
        $this->assertEquals(0, $_SESSION["sumPlayer"]);
    }

    public function testPlayComputer()
    {
        $_SESSION["sumComputer"] = null;
        $this->game21->playComputer();
        $this->assertLessThanOrEqual(26, $_SESSION["sumComputer"]);
        $this->assertGreaterThanOrEqual(21, $_SESSION["sumComputer"]);
    }

    public function testCheckWinnerBothLose()
    {
        $reflector = new ReflectionClass($this->game21);
        $reflectorProperty = $reflector->getProperty("message");
        $reflectorProperty->setAccessible(true);

        $_SESSION["sumComputer"] = 22;
        $_SESSION["sumPlayer"] = 22;

        $this->game21->checkWinner();
        $res = $reflectorProperty->getValue($this->game21);
        $this->assertEquals("Båda förlorade", $res);
    }

    public function testCheckWinnerTie()
    {
        $reflector = new ReflectionClass($this->game21);
        $reflectorProperty = $reflector->getProperty("message");
        $reflectorProperty->setAccessible(true);

        $_SESSION["sumComputer"] = 21;
        $_SESSION["sumPlayer"] = 21;

        $this->game21->checkWinner();
        $res = $reflectorProperty->getValue($this->game21);
        $this->assertEquals("Datorn vinner", $res);
    }

    public function testCheckWinnerBothUnder21ComputerClosest()
    {
        $reflector = new ReflectionClass($this->game21);
        $reflectorProperty = $reflector->getProperty("message");
        $reflectorProperty->setAccessible(true);

        $_SESSION["sumComputer"] = 20;
        $_SESSION["sumPlayer"] = 19;

        $this->game21->checkWinner();
        $res = $reflectorProperty->getValue($this->game21);
        $this->assertEquals("Datorn vinner", $res);
    }

    public function testCheckWinnerBothUnder21PlayerClosest()
    {
        $reflector = new ReflectionClass($this->game21);
        $reflectorProperty = $reflector->getProperty("message");
        $reflectorProperty->setAccessible(true);

        $_SESSION["sumComputer"] = 19;
        $_SESSION["sumPlayer"] = 20;

        $this->game21->checkWinner();
        $res = $reflectorProperty->getValue($this->game21);
        $this->assertEquals("Du vann!!", $res);
    }

    public function testCheckWinnerPlayerUnder21ComputerOver()
    {
        $reflector = new ReflectionClass($this->game21);
        $reflectorProperty = $reflector->getProperty("message");
        $reflectorProperty->setAccessible(true);

        $_SESSION["sumComputer"] = 22;
        $_SESSION["sumPlayer"] = 20;

        $this->game21->checkWinner();
        $res = $reflectorProperty->getValue($this->game21);
        $this->assertEquals("Du vann!!", $res);
    }

    public function testCheckWinnerComputerUnder21PlayerOver()
    {
        $reflector = new ReflectionClass($this->game21);
        $reflectorProperty = $reflector->getProperty("message");
        $reflectorProperty->setAccessible(true);

        $_SESSION["sumComputer"] = 20;
        $_SESSION["sumPlayer"] = 22;

        $this->game21->checkWinner();
        $res = $reflectorProperty->getValue($this->game21);
        $this->assertEquals("Datorn vinner", $res);
    }
}
