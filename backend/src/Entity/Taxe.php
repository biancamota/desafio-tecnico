<?php

namespace Bm\Store\Entity;

class Taxe extends Entity
{
    public function toJsonArray()
    {
        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'percentage' => $this->percentage
        ];
    }
}
