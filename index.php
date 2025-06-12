<?php
require_once __DIR__ . '/api/controllers/Router.php';

$router = new Router();
$router->route($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
