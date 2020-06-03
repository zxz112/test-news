<?php

namespace App;

class Application
{
    private $routes;

    public function __construct()
    {

        $this->routes = [];
    }

    public function get($path, $func)
    {
        $this->routes[] = ['GET', $path, $func];
    }

    public function run()
    {
        $uri = explode('?', $_SERVER['REQUEST_URI']);
        $correctUri = $uri[0];
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        foreach ($this->routes as $route) {
            [$method, $uriRoute, $handle] = $route;
            $correctUriRoute = preg_quote($uriRoute, '/');
            if (preg_match("/^$correctUriRoute$/i" , $correctUri) && ($httpMethod === $method)) {
                echo $handle();
            }
        }
    }
    // END
}
