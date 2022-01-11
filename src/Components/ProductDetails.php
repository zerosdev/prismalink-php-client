<?php

namespace ZerosDev\Prismalink\Components;

use ZerosDev\Prismalink\Constant;
use ZerosDev\Prismalink\Traits\SetterGetter;

class ProductDetails
{
    use SetterGetter;

    public function __construct()
    {
    }

    public function add(string $item_code, string $item_title, int $quantity, int $total, string $currency = 'IDR')
    {
        $this->addItems([
            'item_code' => $item_code,
            'item_title' => $item_title,
            'quantity' => $quantity,
            'total' => strval($total),
            'currency' => $currency,
        ]);
    }

    public function toArray()
    {
        return $this->getItems();
    }

    public function toJson()
    {
        return json_encode($this->getItems());
    }
}
