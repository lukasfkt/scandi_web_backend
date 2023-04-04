<?php

namespace ScandiwebApp\controllers;

use Reflection;
use ReflectionClass;
use ScandiwebApp\models\Book;
use ScandiwebApp\models\DVD;
use ScandiwebApp\models\Furniture;
use ScandiwebApp\repository\ProductRepository;

class ProductController
{
    public function getProducts(ProductRepository $productRepository): void
    {
        $products = $productRepository->getAll();
        $productsJSON = json_encode($products);
        echo $productsJSON;
        return;
    }

    public function saveProduct(ProductRepository $productRepository)
    {
        $payload = json_decode(file_get_contents("php://input"), true);
        if (!$payload['name'] || !$payload['sku'] || !$payload['price'] || !$payload['productType']) {
            echo "Required fields are missing";
            http_response_code(400);
            exit();
        }

        if (!$productRepository->verifySKU($payload['sku'])) {
            echo "There is already a product with this sku";
            http_response_code(400);
            exit();
        }

        $productsModelsMap = array(
            'dvd' => function ($payload) {
                return new DVD($payload);
            },
            'furniture' => function ($payload) {
                return new Furniture($payload);
            },
            'book' => function ($payload) {
                return new Book($payload);
            }
        );
        $objectToSave = $productsModelsMap[$payload['productType']]($payload);
        $productRepository->save($objectToSave);
        http_response_code(201);
        exit();
    }

    public function deleteProducts(ProductRepository $productRepository)
    {
        $payload = json_decode(file_get_contents("php://input"), true);
        if (!$payload['ids']) {
            http_response_code(400);
            exit();
        }
        if ($productRepository->delete($payload['ids'])) {
            http_response_code(200);
            exit();
        };
        http_response_code(400);
        exit();
    }
}
