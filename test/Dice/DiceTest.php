<?php

namespace Veax\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice
 */
class DiceTest extends TestCase
{
    private $dice;

    protected function setUp(): void
    {
        $this->dice = new Dice();
        $this->assertInstanceOf("\Veax\Dice\Dice", $this->dice);
    }

    public function testCreateDiceWithNoArgument()
    {
        $res = $this->dice->getSides();
        $exp = 6;
        $this->assertEquals($exp, $res);
    }

    public function testCreateDiceWithArgument()
    {
        $dice = new Dice(2);
        $this->assertInstanceOf("\Veax\Dice\Dice", $dice);

        $res = $dice->getSides();
        $exp = 2;
        $this->assertEquals($exp, $res);
    }

    public function testGetLastRollBeforeRoll()
    {
        $res = $this->dice->getLastRoll();
        $exp = null;
        $this->assertEquals($exp, $res);
    }

    public function testGetLastRollAfterRoll()
    {
        $res = $this->dice->rollDice();
        $exp = $this->dice->getLastRoll();
        $this->assertEquals($exp, $res);
    }
}
