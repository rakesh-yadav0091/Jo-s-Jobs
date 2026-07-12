<?php

class EntryPoint {
    private $routes;
    private $authentication;
    
    public function __construct($routes, $authentication) {
        $this->routes = $routes;
        $this->authentication = $authentication;
    }
    
    public function run() {
        $route = $this->getRouteFromUrl();
        $method = $_SERVER['REQUEST_METHOD'];
        
        list($controllerName, $methodName) = $this->routes->getControllerAndMethod($route, $method);
        
        $controllerClass = '\\' . $controllerName;
        
        if (!class_exists($controllerClass)) {
            $controllerClass = '\\HomeController';
            $methodName = 'home';
        }
        
        $controller = new $controllerClass($this->authentication);
        
        if (!method_exists($controller, $methodName)) {
            $methodName = 'home';
        }
        
        echo $controller->$methodName();
    }
    
    private function getRouteFromUrl() {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $path = ltrim($path, '/');
        
        if (empty($path) || $path === 'index.php') {
            return '';
        }
        
        if (strpos($path, '?') !== false) {
            $path = substr($path, 0, strpos($path, '?'));
        }
        
        return $path;
    }
}