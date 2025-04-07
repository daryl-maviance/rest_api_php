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
    getenv('MYSQL_HOST') ?: 'localhost',
    getenv('MYSQL_DATABASE') ?: 'practice',
    getenv('MYSQL_USER') ?: 'daryl',
    getenv('MYSQL_PASSWORD') ?: 'daryl'
);

switch ($route) {
    case "product":
        $gateway = new ProductGateway($database);
        $controller = new ProductController($gateway);
        $id = $path[3] ?? null;
        $controller->processRequest($_SERVER["REQUEST_METHOD"], $id);
        break;

    default:
        http_response_code(404);
        break;
}
?>