<?php

namespace Bm\Store\Entity;

abstract class Entity
{
    protected array $attributes = [];

    public function __set(string $property, $value): void
    {
        $this->attributes[$property] = $value;
    }

    public function __get(string $property)
    {
        return $this->attributes[$property];
    }

    public function getAttributes()
    {
        return $this->attributes;
    }
}
