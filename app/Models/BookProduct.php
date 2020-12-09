<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookProduct extends ShopProduct
{
    use HasFactory;

    public function __construct(
        string $id,
        string $title,
        string $firstName,
        string $mainName,
        string $price,
        int $numPages
    ) {
        parent::__construct(
            $id,
            $title,
            $firstName,
            $mainName,
            $price
        );
        $this->numPages = $numPages;
    }

    public function getNumberOfPages()
    {
        return $this->numPages;
    }
}
