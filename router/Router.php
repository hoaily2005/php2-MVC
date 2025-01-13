<?php
// Router.php
class Router {
    private $routes = [];
    private $middlewares = [];
    
    public function addRoute($path, $handler, $middlewares = []) {
        $this->routes[$path] = [
            'handler' => $handler,
            'middlewares' => $middlewares
        ];
    }
    
    public function addMiddleware($middleware) {
        $this->middlewares[] = $middleware;
    }
    
    public function dispatch() {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Run global middlewares
        foreach ($this->middlewares as $middleware) {
            if (is_callable($middleware)) {
                $middleware();
            }
        }
        
        foreach ($this->routes as $routePath => $route) {
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^/]+)', $routePath);
            $pattern = '@^' . $pattern . '$@';
            
            if (preg_match($pattern, $path, $matches)) {
                foreach ($route['middlewares'] as $middleware) {
                    if (is_callable($middleware)) {
                        $middleware();
                    }
                }
                
                array_shift($matches);
                call_user_func_array($route['handler'], $matches);
                return;
            }
        }
        
        header("HTTP/1.0 404 Not Found");
        echo "404 Not Found";
    }
}