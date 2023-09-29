<?php

namespace Bm\Store\Entity;

class SaleItem extends Entity
{
    public function toJsonArray()
    {
        return [
            'id' => $this->id,
            'sale_id' => $this->sale_id,
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
            'item_value' => $this->item_value,
            'tax_value' => $this->tax_value
        ];
    }
}
