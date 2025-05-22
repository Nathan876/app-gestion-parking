<?php

namespace App;

class Router {
    protected array $routes;
    protected string $url;

    public function __construct(array $routes) {
        $this->routes = $routes;
        $this->url = $_SERVER['REQUEST_URI'];
        $this->run();
    }

    protected function extractParams($url, $rule) {
        (array) $params = [];
        (array) $urlParts = explode('/', trim($url, '/'));
        (array) $ruleParts = explode('/', trim($rule, '/'));

        foreach ($ruleParts as $index => $rulePart) {
            if (strpos($rulePart, ':') === 0 && isset($urlParts[$index])) {
                $paramName = substr($rulePart, 1);
                $params[$paramName] = $urlParts[$index];
            }
        }

        return $params;
    }

    protected function matchRule($url, $rule) {
        (array) $urlParts = explode('/', trim($url, '/'));
        (array) $ruleParts = explode('/', trim($rule, '/'));

        if (count($urlParts) !== count($ruleParts)) {
            return false;
        }

        foreach ($ruleParts as $index => $rulePart) {
            if ($rulePart !== $urlParts[$index] && strpos($rulePart, ':') !== 0) {
                return false;
            }
        }

        return true;
    }

    protected function run() {
        ob_clean();
        $url = str_replace('/app-gestion-parking/backend/index.php/', '', parse_url($this->url, PHP_URL_PATH));
        $method = strtolower($_SERVER['REQUEST_METHOD']);

        foreach ($this->routes as $route => $controllerClass) {
            if ($this->matchRule($url, $route)) {
                $params = $this->extractParams($url, $route);
                $controller = new $controllerClass($params);

                $component = explode('/', trim($url, '/'))[0] ?? 'index';
                $methodName = $method . ucfirst($component);

                if (method_exists($controller, $methodName)) {
                    $result = $controller->$methodName();

                    if ($result !== null) {
                        header('Content-Type: application/json');
                        echo json_encode($result);
                    }

                    return;
                }

                http_response_code(404);
                echo json_encode(['code' => '404', 'message' => "Méthode $methodName non trouvée"]);
                return;
            }
        }

        http_response_code(404);
        echo json_encode(['code' => '404', 'message' => 'Not Found']);
    }
}