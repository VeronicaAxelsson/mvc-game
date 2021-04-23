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

    /**
     *  Verify that dice gets 6 sides when created with no argument
     */
    public function testCreateDiceWithNoArgument()
    {
        $res = $this->dice->getSides();
        $exp = 6;
        $this->assertEquals($exp, $res);
    }

    /**
     *  Verify that dice gets given amount of  sides when created
     * with given argument
     */
    public function testCreateDiceWithArgument()
    {
        $dice = new Dice(2);
        $this->assertInstanceOf("\Veax\Dice\Dice", $dice);

        $res = $dice->getSides();
        $exp = 2;
        $this->assertEquals($exp, $res);
    }

    /**
     *  Verify that lastRoll is null before first throw
     */
    public function testGetLastRollBeforeRoll()
    {
        $res = $this->dice->getLastRoll();
        $exp = null;
        $this->assertEquals($exp, $res);
    }

    /**
     *  Verify that roll is saved and retrivable with getLastRoll
     */
    public function testGetLastRollAfterRoll()
    {
        $res = $this->dice->rollDice();
        $exp = $this->dice->getLastRoll();
        $this->assertEquals($exp, $res);
    }

    /**
     *  Verify that rollDice returns value within number of sides
     */
    public function testRollDiceWithDefaultSides()
    {
        $res = $this->dice->rollDice();
        $this->assertLessThanOrEqual(6, $res);
        $this->assertGreaterThanOrEqual(1, $res);
    }

    /**
     *  Verify that rollDice returns value within number of set sides
     */
    public function testRollDiceWithSetSides()
    {
        $dice = new Dice(2);
        $this->assertInstanceOf("\Veax\Dice\Dice", $dice);

        $res = $dice->rollDice();
        $this->assertLessThanOrEqual(2, $res);
        $this->assertGreaterThanOrEqual(1, $res);
    }
}
