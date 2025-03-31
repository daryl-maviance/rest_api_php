<?php
declare(strict_types=1);

spl_autoload_register(function ($class){
    require __DIR__ . "/src/$class.php";
});


set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");

header("COntent-Type: application/json; charset=UTF-8");

$path = explode( "/", $_SERVER["REQUEST_URI"]);
$route = $path[2];
$database = new Database('localhost', 'practice', 'daryl', 'daryl');

switch ($route) {
    case "product":
        $gateway = new ProductGateway($database);
        $controller = new ProductController($gateway);
        $id = $path[3] ?? null;
        $controller -> processRequest($_SERVER["REQUEST_METHOD"], $id);
        //$conn = $database->getConnection();

        break;
    
    default:
        http_response_code(404);
        break;
} 

?>