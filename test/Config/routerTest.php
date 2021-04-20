<?php

declare(strict_types=1);

namespace Veax\Config;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for the configuration file router.php.
 */
class RouterTest extends TestCase
{
    private $routerFile = INSTALL_PATH . "/config/router.php";
    /**
     * Require the router file.
     */
    public function testRequireConfigFile()
    {
        $exp = 1;
        $res = require $this->routerFile;
        $this->assertEquals($exp, $res);
    }
}
