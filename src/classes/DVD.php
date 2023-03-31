<?php

namespace ScandiwebApp\classes;

class DVD extends Product
{
    protected int $size;

    public function __construct(
        array $args
    ) {
        if (isset($args['id'])) {
            $this->id = $args['id'];
        }
        $this->sku = $args['sku'];
        $this->name = $args['name'];
        $this->price = floatval($args['price']);
        $this->size = intval($args['size']);
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

    public function getClass(): string
    {
        return __CLASS__;
    }
}
