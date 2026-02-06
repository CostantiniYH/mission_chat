<?php
namespace App\Core;
use App\Core\Middleware;
use RuntimeException;

final class Router
{
    /** @var Route[] */
    private $routes = [];

    private $groupMiddleware = [];

    private $groupPrefix = '';

    /* ==========================
       HTTP METHODS
       ========================== */

    public function get($path, $handler)
    {
        return $this->add(['GET'], $path, $handler);
    }

    public function post($path, $handler)
    {
        return $this->add(['POST'], $path, $handler);
    }

    public function put($path, $handler)
    {
        return $this->add(['PUT'], $path, $handler);
    }

    public function delete($path, $handler)
    {
        return $this->add(['DELETE'], $path, $handler);
    }

    /* ==========================
       CORE
       ========================== */

    public function add($methods, $path, $handler)
    {
        $this->routes[] = new Route(
            $methods,
            $this->groupPrefix . $path,
            $handler,
            $this->groupMiddleware
        );

        return $this;
    }

    public function group($options, $callback)
    {
        $previousPrefix = $this->groupPrefix;
        $previousMiddleware = $this->groupMiddleware;

        $this->groupPrefix .= $options['prefix'] ?? '';
        $this->groupMiddleware = array_merge(
            $this->groupMiddleware,
            $options['middleware'] ?? []
        );

        $callback($this);

        $this->groupPrefix = $previousPrefix;
        $this->groupMiddleware = $previousMiddleware;
    }

    public function dispatch($method, $uri)
    {
        $uri = parse_url($uri, PHP_URL_PATH);

        foreach ($this->routes as $route) {
            $params = $route->matches($method, $uri);

            if ($params !== null) {
                return $this->runMiddlewares(
                    $route->middlewares,
                    fn() => $this->invokeHandler($route->handler, $params)
                );
            }
        }

        throw new RuntimeException('404 Not Found');
    }

    private function runMiddlewares($middlewares, $handler)
    {
        $pipeline = array_reduce(
            array_reverse($middlewares),
            fn($next, Middleware $middleware) =>
                fn() => $middleware->handle($next),
            $handler
        );

        return $pipeline();
    }

    private function invokeHandler($handler, $params)
{
    // Cas 1 : closure ou fonction callable
    if ($handler instanceof \Closure) {
        return call_user_func_array($handler, $params);
    }

    // Cas 2 : [Controller::class, 'method']
    if (is_array($handler)) {
        [$class, $method] = $handler;

        if (!class_exists($class)) {
            throw new RuntimeException("Controller $class introuvable");
        }

        $controller = new $class();

        if (!method_exists($controller, $method)) {
            throw new RuntimeException("Méthode $method introuvable dans $class");
        }

        return call_user_func_array([$controller, $method], $params);
    }

    throw new RuntimeException('Handler de route invalide');
}

}
