<?php

namespace ScandiwebApp\repository;

class ProductRepository
{
    protected $database;
    const TABLE_NAME = "products";

    public function __construct($database)
    {
        $this->database = $database;
    }

    static public function test()
    {
        return "TEST";
    }

    // Select all items from the database and returns an array
    public function getAll(): array
    {
        $sql = "SELECT * FROM products";
        $result_query = $this->database->query($sql);

        if (!$result_query) {
            exit("Query failed");
        }

        $products = self::resultToArray($result_query);
        $result_query->free();
        return $products;
    }

    // Transform query result into array
    static protected function resultToArray($result): array
    {
        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    // Saves a new product in the db
    public function save($obj): void
    {
        $sql = "INSERT INTO " . self::TABLE_NAME;
        $sql .= " (sku,name,price,weight,size,dimensions)";
        $sql .= " VALUES ('" . $obj->getSku() . "','" . $obj->getName() . "'," . $obj->getPrice();
        $sql .= method_exists($obj, 'getWeight') ? "," . $obj->getWeight() : ",NULL";
        $sql .= method_exists($obj, 'getSize') ? "," . $obj->getSize() : ",NULL";
        $sql .= method_exists($obj, 'getDimensions') ? ",'" . $obj->getDimensions() . "'" : ",NULL";
        $sql .= ")";
        $result = $this->database->query($sql);
        return;
    }

    // Verify if this sku exists in db
    public function verifySKU($sku): bool
    {
        $sql = "SELECT * FROM " . self::TABLE_NAME;
        $sql .= " WHERE sku='" . $sku . "'";
        $result_query = $this->database->query($sql);
        if ($result_query->num_rows > 0) {
            return false;
        }
        return true;
    }

    // Delete products in db
    public function delete($productsId): bool
    {
        if (count($productsId) === 0) {
            return false;
        }
        $idsToDelete = "";
        foreach ($productsId as $productId) {
            $idsToDelete .= $productId . ",";
        }
        $idsToDelete = rtrim($idsToDelete, ',');
        $sql = "DELETE FROM " . self::TABLE_NAME;
        $sql .= " WHERE id IN (" . $idsToDelete . ")";
        $this->database->query($sql);
        return true;
    }
}
