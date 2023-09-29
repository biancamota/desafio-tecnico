<?php

namespace Bm\Store\Routing;

class Router
{
    private array $routes = [];

    public function add(string $uri, string $httpMethod, string $controller)
    {
        $this->routes[] = new Route($uri, $httpMethod, $controller);
    }

    public function get(string $uri, string $controller)
    {
        $this->routes[] = new Route($uri, 'GET', $controller);
    }

    public function post(string $uri, string $controller)
    {
        $this->routes[] = new Route($uri, 'POST', $controller);
    }

    public function put(string $uri, string $controller)
    {
        $this->routes[] = new Route($uri, 'PUT', $controller);
    }

    public function delete(string $uri, string $controller)
    {
        $this->routes[] = new Route($uri, 'DELETE', $controller);
    }

    public function init()
    {        
        foreach ($this->routes as $route) {
            if ($route->match()) {
                return (new Dispatcher)->dispatch($route);
            }
        }
    }
}
