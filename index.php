<?php
declare(strict_types=1);

spl_autoload_register(function ($class){
    require __DIR__ . "/src/$class.php";
});

set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");

header("Content-Type: application/json; charset=UTF-8");

$path = explode("/", $_SERVER["REQUEST_URI"]);
//var_dump($path);
$route = $path[2];


// Use environment variables for database connection
$database = new Database(
    getenv('MYSQL_HOST'),
    getenv('MYSQL_DATABASE'),
    getenv('MYSQL_USER'),
    getenv('MYSQL_PASSWORD')
);

switch ($route) {
    case "product":
        $gateway = new ProductGateway($database);
        $controller = new ProductController($gateway);
        $id = $path[3] ?? null;
        $controller->processRequest($_SERVER["REQUEST_METHOD"], $id);
        break;

    case "user":
        $gateway = new UserGateway($database);
        $controller = new UserController($gateway);
        $id = $path[3] ?? null;
        $controller->processRequest($_SERVER["REQUEST_METHOD"], $id);
        break;

    case "customer":
        $gateway = new CustomerGateway($database);
        $controller = new CustomerController($gateway);
        $id = $path[3] ?? null;
        $controller->processRequest($_SERVER["REQUEST_METHOD"], $id);
        break;

    default:
        http_response_code(404);
        break;
}
?>