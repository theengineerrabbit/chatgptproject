<?php
class Router {
    private $routes = [];

    public function __construct() {
        $this->routes = [
            'POST /login' => ['AuthController', 'login'],
            'POST /expenses' => ['TransactionController', 'addExpense'],
            'POST /incomes' => ['TransactionController', 'addIncome'],
            'POST /bankaccounts' => ['AccountController', 'addAccount'],
            'GET /bankaccounts' => ['AccountController', 'listAccounts'],
            'POST /categories' => ['CategoryController', 'addCategory'],
            'GET /categories' => ['CategoryController', 'listCategories'],
            'GET /summary' => ['TransactionController', 'summary'],
        ];
    }

    public function route($method, $uri) {
        $path = parse_url($uri, PHP_URL_PATH);
        $key = "$method $path";
        if (isset($this->routes[$key])) {
            list($class, $func) = $this->routes[$key];
            require_once __DIR__ . "/{$class}.php";
            $controller = new $class();
            $controller->$func();
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Route not found']);
        }
    }
}
