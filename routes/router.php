<?php

function load(string $controller, string $action, $productRepository)
{
    try {
        // Check if controller exist
        $controllerNamespace = "\\ScandiwebApp\\controllers\\$controller";
        if (!class_exists($controllerNamespace)) {
            throw new Exception("Controller $controller does not exist");
        }

        $controllerInstance = new $controllerNamespace();

        if (!method_exists($controllerInstance, $action)) {
            throw new Exception("Method $action does not exist in controller $controller");
        }
        $controllerInstance->$action($productRepository);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

$routes = [
    "GET" => [
        "/getProducts" => fn ($productRepository) => load("ProductController", "getProducts", $productRepository),
    ],
    "POST" => [
        "/saveProduct" => fn ($productRepository) => load("ProductController", "saveProduct", $productRepository),
        "/deleteProducts" => fn ($productRepository) => load("ProductController", "deleteProducts", $productRepository)
    ],
];
