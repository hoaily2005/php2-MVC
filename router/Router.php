<?php

class Router {
    private $routes = [];

    public function addRoute($route, $callback) {
        $this->routes[$route] = $callback;
    }

    public function dispatch() {
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        foreach ($this->routes as $route => $callback) {
            $pattern = "#^" . preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_]+)', $route) . "$#";
            if (preg_match($pattern, $url, $matches)) {
                array_shift($matches);
                return call_user_func_array($callback, $matches);
            }
        }
        echo "404 Not Found";
    }
}
?>