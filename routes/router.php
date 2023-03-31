<?php

function load(string $controller, string $action)
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
        $controllerInstance->$action();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

$routes = [
    "GET" => [
        "/getProducts" => fn () => load("ProductController", "getProducts"),
    ],
    "POST" => [
        "/saveProduct" => fn () => load("ProductController", "saveProduct"),
        "/deleteProducts" => fn () => load("ProductController", "deleteProducts")
    ],
];
