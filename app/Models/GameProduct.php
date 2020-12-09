<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameProduct extends ShopProduct
{
    use HasFactory;

    // Pan European game information
    private $pegi;

    public function __construct(
        string $id,
        string $title,
        string $firstName,
        string $mainName,
        string $price,
        string $pegi
    ) {
        parent::__construct(
            $id,
            $title,
            $firstName,
            $mainName,
            $price
        );
        $this->pegi = $pegi;
    }
  
    public function getPegi()
    {
        return $this->pegi;
    }
}
