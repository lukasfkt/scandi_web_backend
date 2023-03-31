<?php

namespace ScandiwebApp\classes;

class Book extends Product
{
    protected float $weight;

    public function __construct(
        array $args
    ) {
        if (isset($args['id'])) {
            $this->id = $args['id'];
        }
        $this->sku = $args['sku'];
        $this->name = $args['name'];
        $this->price = floatval($args['price']);
        $this->weight = floatval($args['weight']);
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

    public function getClass(): string
    {
        return __CLASS__;
    }
}
