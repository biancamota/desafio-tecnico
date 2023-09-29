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
            'categoryId' => $this->category_id,
        ];
    }
}
