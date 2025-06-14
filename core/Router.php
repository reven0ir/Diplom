<?php

namespace PHPFramework;

class Router
{

    public Request $request;
    public Response $response;
    protected array $routes = [];
    public array $route_params = [];

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function add($path, $callback, $method): self
    {
        $path = trim($path, '/');
        if (is_array($method)) {
            $method = array_map('strtoupper', $method);
        } else {
            $method = [strtoupper($method)];
        }

        $this->routes[] = [
            'path' => "/{$path}",
            'callback' => $callback,
            'middleware' => null,
            'method' => $method
        ];
        /*foreach ($method as $item_method) {
            $this->routes[$item_method]["/{$path}"] = [
                'callback' => $callback,
                'middleware' => null,
            ];
        }*/
        return $this;
    }

    public function get($path, $callback): self
    {
        return $this->add($path, $callback, 'GET');
    }

    public function post($path, $callback): self
    {
        return $this->add($path, $callback, 'POST');
    }

    public function dispatch(): mixed
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->matchRoute($method, $path);

        if (false === $callback) {
            abort();
        }
        if (is_array($callback['callback'])) {
            $callback['callback'][0] = new $callback['callback'][0];
            app()->layout = $callback['callback'][0]->layout ?? LAYOUT;
        }
        return call_user_func($callback['callback']);
    }

    protected function matchRoute($method, $path)
    {
        foreach ($this->routes as $route) {
            if ((preg_match("#^{$route['path']}$#", "/{$path}", $matches)) && (in_array($this->request->getMethod(), $route['method']))) {

                if ($route['middleware']) {
                    $middleware = MIDDLEWARE[$route['middleware']] ?? false;
                    if ($middleware) {
                        (new $middleware)->handle();
                    }
                }

                foreach ($matches as $k => $v) {
                    if (is_string($k)) {
                        $this->route_params[$k] = $v;
                    }
                }
                return $route;

            }
        }
        return false;
    }

    public function only($middleware): self
    {
        $this->routes[array_key_last($this->routes)]['middleware'] = $middleware;
        return $this;
    }

}