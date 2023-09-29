<?php

namespace Bm\Store\Entity;

class Category extends Entity
{
    public function toJsonArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name
        ];
    }
}
