<?php

namespace Core;

use Core\Middleware\Middleware;

class Router
{

    protected $routes = [];

    // Add a route to the internal list
    public function add($method, $uri, $controller)
    {
        $this->routes[] = [
            'uri' => $uri,
            'controller' => $controller,
            'method' => $method,
            'middleware' => null
        ];

        return $this; // Allows for method chaining
    }

    // Helper methods for specific HTTP Verbs
    public function get($uri, $controller)
    {
        return $this->add('GET', $uri, $controller);
    }
    public function post($uri, $controller)
    {
        return $this->add('POST', $uri, $controller);
    }
    public function delete($uri, $controller)
    {
        return $this->add('DELETE', $uri, $controller);
    }
    public function patch($uri, $controller)
    {
        return $this->add('PATCH', $uri, $controller);
    }
    public function put($uri, $controller)
    {
        return $this->add('PUT', $uri, $controller);
    }


    public function route($uri, $method)
    {
        foreach ($this->routes as $route) {
            if ($route['uri'] === $uri && $route['method'] === strtoupper($method)) {

                if ($route['middleware']) {
                    Middleware::resolve($route['middleware']);
                }

                $action = $route['controller'];

                // If it's a controller class method
                if (is_array($action)) {
                    [$class, $actionMethod] = $action;

                    return (new $class)->$actionMethod();
                }

                // If it's a simple PHP file
                return require basePath('/http/controllers/' . $action);
            }
        }

        $this->abort();
    }

    protected function abort($code = 404)
    {
        http_response_code($code);
        require basePath("views/{$code}.view.php");
        die();
    }

    public function previousUrl()
    {
        return $_SERVER['HTTP_REFERER'];
    }

    public function only($key)
    {
        $this->routes[array_key_last($this->routes)]['middleware'] = $key;

        return $this;
    }
}
