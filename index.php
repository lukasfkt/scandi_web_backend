<?php

use ScandiwebApp\repository\ProductRepository;

include_once('./db/initialize.php');
require "./vendor/autoload.php";
require "./routes/router.php";

function cors()
{
    // Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            // may also be using PUT, PATCH, HEAD etc
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }
}

try {
    $productRepository = new ProductRepository($database);
    $uri = parse_url($_SERVER["REQUEST_URI"])["path"];
    $request = $_SERVER["REQUEST_METHOD"];
    cors();

    if (!isset($routes[$request])) {
        http_response_code(404);
        exit;
    }

    if (!array_key_exists($uri, $routes[$request])) {
        http_response_code(404);
        exit;
    }

    $controller = $routes[$request][$uri]($productRepository);
} catch (Exception $e) {
    $e->getMessage();
}
