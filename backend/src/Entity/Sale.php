<?php

namespace Bm\Store\Entity;

class Sale extends Entity
{
    public function toJsonArray()
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'total_purchase' => $this->total_purchase,
            'total_taxes' => $this->total_taxes,
        ];
    }
}
