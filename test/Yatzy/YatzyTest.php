<?php

namespace Veax\Yatzy;

use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * Test cases for class Game for Yatzy
 */
class YatzyTest extends TestCase
{
    private $yatzy;
    // private $data;

    public function setUp(): void
    {
        $this->yatzy = new Game();
        $this->assertInstanceOf("\Veax\Yatzy\Game", $this->yatzy);
    }

    /**
     * Check that playGame sets yatzySum in SESSION
     */
    public function testGameSetUpWithPlayGame()
    {
        $this->yatzy->playGame();
        $this->assertArrayHasKey("yatzySum", $_SESSION);
    }

    /**
     * Check that rollDice adds a array of 5 values to data["value"]
     */
    public function testRollDice()
    {
        $this->yatzy->rollDice();
        $res = $this->yatzy->getData();
        $this->assertArrayHasKey("values", $res);
        $this->assertCount(5, $res["values"]);
    }

    /**
     * Check that moveDice places dice values from POST to savedValues
     * and only throws 3 dice instead of 5 -> saves 3 values in data["values"]
     */
    public function testMoveDiceWithPresetPostData()
    {
        $reflector = new ReflectionClass($this->yatzy);
        $reflectorProperty = $reflector->getProperty("throws");
        $reflectorProperty->setAccessible(true);

        $_POST = [
            1 => '6',
            2 => '6',
            'throw' => 'Kasta'
        ];
        $throwsBefore = $reflectorProperty->getValue($this->yatzy);
        $this->yatzy->moveDice();
        $res = $this->yatzy->getData();
        $throwsAfter = $reflectorProperty->getValue($this->yatzy);

        $this->assertEquals([6, 6], $res["savedValues"]);
        $this->assertCount(3, $res["values"]);
        $this->assertEquals(3, $res["dice"]);
        $this->assertEquals($throwsAfter, $throwsBefore + 1);
    }

    /**
     * Check that all dice moves to savedValues when no throws left
     */
    public function testMoveDiceFromValuesToSavedValuesWithNoThrowsLeft()
    {
        $reflector = new ReflectionClass($this->yatzy);
        $reflectorProperty = $reflector->getProperty("throws");
        $reflectorProperty->setAccessible(true);
        $reflectorProperty->setValue($this->yatzy, 2);

        $this->yatzy->moveDice();
        $res = $this->yatzy->getData();
        $this->assertEquals(0, $res["dice"]);
        $this->assertCount(5, $res["savedValues"]);
        $this->assertCount(0, $res["values"]);
    }

    /**
     * Check that all dice moves to savedValues when all dice choosen
     */
    public function testMoveDiceFromValuesToSavedValuesWithNoValuesLeft()
    {
        $_POST = [
            1 => '6',
            2 => '6',
            3 => '6',
            4 => '6',
            5 => '6',
            'throw' => 'Kasta'
        ];

        $this->yatzy->moveDice();
        $res = $this->yatzy->getData();
        $this->assertEquals(0, $res["dice"]);
        $this->assertCount(5, $res["savedValues"]);
        $this->assertCount(0, $res["values"]);
    }

    /**
     * Check that all values are summed and saved in data["score"] with
     * dice value as key and added to SESSION["yatzySum"]
     */
    public function testSumRound()
    {
        $reflector = new ReflectionClass($this->yatzy);
        $reflectorProperty = $reflector->getProperty("savedValues");
        $reflectorProperty->setAccessible(true);
        $reflectorProperty->setValue($this->yatzy, [1, 1, 1, 1, 1]);

        $_POST = ['diceValue' => '1'];

        $this->yatzy->sumRound();
        $res = $this->yatzy->getData();
        $this->assertEquals([1 => 5], $res["score"]);
        $this->assertEquals(5, $_SESSION["yatzySum"]);
    }

    /**
     * Check that new round starts when there are rounds left
     */
    public function testNewRoundWithRoundsLeft()
    {
        $reflector = new ReflectionClass($this->yatzy);
        $reflectorProperty = $reflector->getProperty("round");
        $reflectorProperty->setAccessible(true);

        $roundBefore = $reflectorProperty->getValue($this->yatzy);
        $this->yatzy->newRound();
        $res = $this->yatzy->getData();
        $roundAfter = $reflectorProperty->getValue($this->yatzy);

        $this->assertEquals([], $res["savedValues"]);
        $this->assertEquals(5, $res["dice"]);
        $this->assertEquals("Tryck på kasta för att kasta tärningarna!", $res["message"]);
        $this->assertEquals($roundAfter, $roundBefore + 1);
    }

    /**
     * Check that game ends when there are no rounds left
     */
    public function testNewRoundWithNoRoundsLeft()
    {
        $reflector = new ReflectionClass($this->yatzy);
        $reflectorProperty = $reflector->getProperty("round");
        $reflectorProperty->setAccessible(true);
        $reflectorProperty->setValue($this->yatzy, 6);

        $_SESSION["yatzySum"] = 1;

        $this->yatzy->newRound();
        $res = $this->yatzy->getData();

        $this->assertEquals("Game over", $res["message"]);
        $this->assertEquals([], $res["savedValues"]);
        $this->assertEquals(1, $res["score"]["summa"]);
    }

    /**
     * Check that game ends when there are no rounds left and bonus is
     * set when yatzySum over 63
     */
    public function testNewRoundWithNoRoundsLeftAndBonus()
    {
        $reflector = new ReflectionClass($this->yatzy);
        $reflectorProperty = $reflector->getProperty("round");
        $reflectorProperty->setAccessible(true);
        $reflectorProperty->setValue($this->yatzy, 6);

        $_SESSION["yatzySum"] = 63;

        $this->yatzy->newRound();
        $res = $this->yatzy->getData();
        $this->assertArrayHasKey("bonus", $res["score"]);
        $this->assertEquals(50, $res["score"]["bonus"]);
    }
}
