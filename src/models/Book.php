<?php

namespace ScandiwebApp\models;

class Book extends Product
{
    private float $weight;

    public function __construct(
        array $args
    ) {
        if (isset($args['id'])) {
            $this->setId($args['id']);
        }
        $this->setSku($args['sku']);
        $this->setName($args['name']);
        $this->setPrice(floatval($args['price']));
        $this->setWeight(floatval($args['weight']));
    }

    // Getters and Setters
    public function getWeight(): float
    {
        return $this->weight;
    }

    public function setWeight($weight): void
    {
        $this->weight = $weight;
    }
}
