<?php
namespace App\Core;

final class Route
{
    public function __construct(
        public $methods,
        public $path,
        public $handler,
        public $middlewares = []
    ) {}

    public function matches($method, $uri)
    {
        if (!in_array($method, $this->methods, true)) {
            return null;
        }

        $pattern = preg_replace('#\{([\w]+)\}#', '(?P<$1>[^/]+)', $this->path);
        $pattern = "#^{$pattern}$#";

        if (!preg_match($pattern, $uri, $matches)) {
            return null;
        }

        return array_filter($matches, fn($k) => !is_int($k), ARRAY_FILTER_USE_KEY);
    }
}
