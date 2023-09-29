<?php

namespace Bm\Store\Routing;

use Exception;

class Dispatcher
{
    public function dispatch(Route $route)
    {
        $controller = $route->controller;

        if (!str_contains($controller, ':')) {
            throw new Exception("Syntax error in {$controller}");
        }

        [$controller, $action] = explode(':', $controller);

        $controllerInstance = "Bm\\Store\\Controller\\" . $controller;

        if (!class_exists($controllerInstance)) {
            throw new Exception("Controller {$controller} does not exist");
        }

        $controller = new $controllerInstance;

        if (!method_exists($controller, $action)) {
            throw new Exception("Action {$action} does not exist");
        }

        $args = in_array($route->httpMethod, ['POST', 'PUT']) 
            ? [json_decode(file_get_contents('php://input')), $route->params] 
            : [$route->params];

        call_user_func_array([$controller, $action], $args);
    }
}
