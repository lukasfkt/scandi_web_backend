<?php

namespace ScandiwebApp\models;

class Furniture extends Product
{
    protected string $dimensions;

    public function __construct(
        array $args
    ) {
        if (isset($args['id'])) {
            $this->setId($args['id']);
        }
        $this->setSku($args['sku']);
        $this->setName($args['name']);
        $this->setPrice(floatval($args['price']));
        isset($args['dimensions']) ? $this->setDimensions($args['dimensions']) : $this->setDimensions($args['height'] . 'x' . $args['width'] . 'x' . $args['length']);
    }

    // Getters and Setters
    public function getDimensions()
    {
        return $this->dimensions;
    }

    public function setDimensions($dimensions)
    {
        $this->dimensions = $dimensions;
    }
}
