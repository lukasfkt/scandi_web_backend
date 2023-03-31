<?php

namespace ScandiwebApp\controllers;

use ScandiwebApp\classes\Book;
use ScandiwebApp\classes\DVD;
use ScandiwebApp\classes\Furniture;
use ScandiwebApp\classes\Product;

class ProductController
{

    public function getProducts(): void
    {
        $products = Product::getAll();
        $productsJSON = json_encode($products);
        echo $productsJSON;
        return;
    }

    public function saveProduct()
    {
        $payload = json_decode(file_get_contents("php://input"), true);
        if (!$payload['name'] || !$payload['sku'] || !$payload['price'] || !$payload['productType']) {
            echo "Required fields are missing";
            http_response_code(400);
            exit();
        }
        switch ($payload['productType']) {
            case 'dvd':
                if (!isset($payload['size'])) {
                    echo "Size field is missing";
                    http_response_code(400);
                    exit();
                }
                $dvd = new DVD($payload);
                if ($dvd->save()) {
                    http_response_code(201);
                    exit();
                }
                break;
            case 'furniture':
                if (!isset($payload['height']) || !isset($payload['width']) || !isset($payload['length'])) {
                    echo "The height, width and length fields are missing";
                    http_response_code(400);
                    exit();
                }
                $furniture = new Furniture($payload);
                if ($furniture->save()) {
                    http_response_code(201);
                    exit();
                }
                break;
            case 'book':
                if (!isset($payload['weight'])) {
                    echo "Weight field is missing";
                    http_response_code(400);
                    exit();
                }
                $book = new Book($payload);
                if ($book->save()) {
                    http_response_code(201);
                    exit();
                }
                break;
        }
        echo "There is already a product with this sku";
        http_response_code(400);
        exit();
    }

    public function deleteProducts()
    {
        $payload = json_decode(file_get_contents("php://input"), true);
        if (!$payload['ids']) {
            http_response_code(400);
            exit();
        }
        if (Product::delete($payload['ids'])) {
            http_response_code(200);
            exit();
        };
        http_response_code(400);
        exit();
    }
}
