<?php

class Router {
    private $routes = [
        "GET" => [],
        "POST" => [],
        "DELETE" => []
    ];

    public function get($path, $callback) {
        $this->routes["GET"][$path] = $callback;
    }

    public function post($path, $callback) {
        $this->routes["POST"][$path] = $callback;
    }

    public function delete($path, $callback) {
        $this->routes["DELETE"][$path] = $callback;
    }

    private function getCurrentPath() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Hilangkan trailing slash, kecuali root
        if ($uri !== "/" && substr($uri, -1) === "/") {
            $uri = rtrim($uri, "/");
        }

        return $uri;
    }

    public function run() {
        $method = $_SERVER["REQUEST_METHOD"];
        $path = $this->getCurrentPath();

        // Cek route 100% match
        if (isset($this->routes[$method][$path])) {
            return call_user_func($this->routes[$method][$path]);
        }

        // Cek dynamic route (misal: /gps/1)
        foreach ($this->routes[$method] as $route => $callback) {
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([a-zA-Z0-9_-]+)', $route);
            $pattern = "#^" . $pattern . "$#";

            if (preg_match($pattern, $path, $matches)) {
                array_shift($matches); // hapus full match
                return call_user_func_array($callback, $matches);
            }
        }

        // Route tidak ditemukan
        Response::json([
            "status" => "error",
            "message" => "Route not found"
        ], 404);
    }
}
