<?php

/**
 * Load the routes into the router, this file is included from
 * `htdocs/index.php` during the bootstrapping to prepare for the request to
 * be handled.
 */

declare(strict_types=1);

use FastRoute\RouteCollector;

$router->addRoute("GET", "/test", function () {
    // A quick and dirty way to test the router or the request.
    return "Testing response";
});

$router->addRoute("GET", "/", "\Mos\Controller\Index");
$router->addRoute("GET", "/debug", "\Mos\Controller\Debug");
$router->addRoute("GET", "/twig", "\Mos\Controller\TwigView");

$router->addGroup("/session", function (RouteCollector $router) {
    $router->addRoute("GET", "", ["\Mos\Controller\Session", "index"]);
    $router->addRoute("GET", "/destroy", ["\Mos\Controller\Session", "destroy"]);
});

$router->addGroup("/game21", function (RouteCollector $router) {
    $router->addRoute("GET", "", ["\Veax\Controller\Game21", "index"]);
    $router->addRoute("POST", "", ["\Veax\Controller\Game21", "roll"]);
    $router->addRoute("POST", "/end", ["\Veax\Controller\Game21", "end"]);
    $router->addRoute("POST", "/reset", ["\Veax\Controller\Game21", "reset"]);
    $router->addRoute("POST", "/newround", ["\Veax\Controller\Game21", "newRound"]);
});

$router->addGroup("/yatzy", function (RouteCollector $router) {
    $router->addRoute("GET", "", ["\Veax\Controller\Yatzy", "index"]);
    $router->addRoute("POST", "/throw", ["\Veax\Controller\Yatzy", "throw"]);
    $router->addRoute("POST", "/endround", ["\Veax\Controller\Yatzy", "endRound"]);
    $router->addRoute("POST", "/newround", ["\Veax\Controller\Yatzy", "newRound"]);
});

$router->addGroup("/some", function (RouteCollector $router) {
    $router->addRoute("GET", "/where", ["\Mos\Controller\Sample", "where"]);
});
