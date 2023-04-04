<?php

namespace ScandiwebApp\models;

class DVD extends Product
{
    protected int $size;

    public function __construct(
        array $args
    ) {
        if (isset($args['id'])) {
            $this->setId($args['id']);
        }
        $this->setSku($args['sku']);
        $this->setName($args['name']);
        $this->setPrice(floatval($args['price']));
        $this->setSize(intval($args['size']));
    }

    // Getters and Setters
    public function getSize(): int
    {
        return $this->size;
    }

    public function setSize($size): void
    {
        $this->size = $size;
    }
}
