<?php

namespace Bm\Store\Entity;

class Product extends Entity
{
    public function toJsonArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'category_id' => $this->category_id,
        ];
    }
}
