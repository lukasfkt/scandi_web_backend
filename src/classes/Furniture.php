<?php

namespace ScandiwebApp\classes;

class Furniture extends Product
{
    protected string $dimensions;

    public function __construct(
        array $args
    ) {
        if (isset($args['id'])) {
            $this->id = $args['id'];
        }
        $this->sku = $args['sku'];
        $this->name = $args['name'];
        $this->price = floatval($args['price']);
        isset($args['dimensions']) ? $this->dimensions = $args['dimensions'] : $this->dimensions = $args['height'] . 'x' . $args['width'] . 'x' . $args['length'];
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

    public function getClass(): string
    {
        return __CLASS__;
    }
}
