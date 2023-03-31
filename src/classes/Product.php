<?php

namespace ScandiwebApp\classes;

class Product
{
    static protected $database;
    protected int $id;
    protected string $sku;
    protected string $name;
    protected float $price;

    const TABLE_NAME = "products";

    // Getters and Setters
    public function getId(): int
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function setSku($sku): void
    {
        $this->sku = $sku;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice($price): void
    {
        $this->price = $price;
    }

    // Set the database
    static public function set_database($database)
    {
        self::$database = $database;
    }

    // Select all items from the database and returns an array
    static public function getAll(): array
    {
        $sql = "SELECT * FROM products";
        $result_query = self::$database->query($sql);

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
    public function save(): bool
    {
        $objProps = $this->getObjPropertiesAsString();
        $valuesToInsert = $this->getValuesToInsertAsString();
        $sql = "INSERT INTO " . self::TABLE_NAME;
        $sql .= " (" . $objProps . ")";
        $sql .= " VALUES (" . $valuesToInsert . ")";
        if (!$this->verifySKU()) {
            return false;
        }
        self::$database->query($sql);
        return true;
    }

    // Get object properties as string
    public function getObjPropertiesAsString(): string
    {
        $objProps = get_object_vars($this);
        $objPropsToString = "";
        foreach ($objProps as $objProp => $value) {
            $objPropsToString .= $objProp . ",";
        }
        return rtrim($objPropsToString, ",");
    }

    // Get values to be insert as string
    public function getValuesToInsertAsString(): string
    {
        $values = get_object_vars($this);
        $valuesString = "";
        foreach ($values as $key => $value) {
            if (gettype($value) == 'string') {
                $valuesString .= "'" . $value . "',";
            } else {
                $valuesString .= $value . ",";
            }
        }
        return rtrim($valuesString, ",");
    }

    // Verify if this sku exists in db
    public function verifySKU(): bool
    {
        $sql = "SELECT * FROM " . self::TABLE_NAME;
        $sql .= " WHERE sku='" . $this->sku . "'";
        $result_query = self::$database->query($sql);
        if ($result_query->num_rows > 0) {
            return false;
        }
        return true;
    }

    // Delete products in db
    static public function delete($productsId): bool
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
        self::$database->query($sql);
        return true;
    }
}
