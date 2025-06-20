<?php
namespace App\controllers;

class Controller {
    protected array $params;
    protected string $reqMethod;
    protected array $body;
    protected string $className;

    public function __construct($params) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $origin = $_SERVER['HTTP_ORIGIN'] ?? '';
        if ($origin && preg_match('/^http:\/\/(localhost|127\.0\.0\.1)(:\d+)?$/', $origin)) {
            header("Access-Control-Allow-Origin: https://trouvetaplace.local");
            header("Access-Control-Allow-Credentials: true");
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
            header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");
        } else {
            header("Access-Control-Allow-Origin: https://trouvetaplace.local");
            header("Access-Control-Allow-Credentials: true");
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
            header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit();
        }

        $this->className = $this->getCallerClassName();
        $this->params = $params;
        $this->reqMethod = strtolower($_SERVER['REQUEST_METHOD']);
        $this->body = (array) json_decode(file_get_contents('php://input'));
    }
    protected function getCallerClassName() {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 2);
        if (isset($backtrace[1]['object'])) {
            $fullClassName = get_class($backtrace[1]['object']);
            return basename(str_replace('\\', '/', $fullClassName));
        }
        return 'Unknown';
    }

    protected function ifMethodExist() {
        $method = $this->reqMethod . $this->className;
        if (method_exists($this, $method)) {
            echo json_encode($this->$method());
            return;
        }

        http_response_code(404);
        echo json_encode([
            'code' => '404',
            'message' => 'Not Found'
        ]);
    }
}