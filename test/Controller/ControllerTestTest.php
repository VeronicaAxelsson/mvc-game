<?php

declare(strict_types=1);

namespace Veax\Controller;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * Test cases for the controller Index.
 */
class ControllerTestTest extends TestCase
{
    /**
     * Try to create the controller class.
     */
    public function testCreateTheControllerClass()
    {
        $controller = new Test();
        $this->assertInstanceOf("\Veax\Controller\Test", $controller);
    }

    /**
     * Check that the controller returns a response.
     */
    public function testControllerReturnsResponse()
    {
        $controller = new Test();

        $exp = "Testing response";
        $res = $controller->index();
        $this->assertEquals($exp, $res);
    }
}
