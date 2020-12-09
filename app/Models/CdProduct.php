<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CdProduct extends ShopProduct
{
    use HasFactory;

    private $playLength;

    public function __construct(
        string $id,
        string $title,
        string $firstName,
        string $mainName,
        string $price,
        string $playLength
    ) {
        parent::__construct(
            $id,
            $title,
            $firstName,
            $mainName,
            $price
        );
        $this->playLength = $playLength;
    }

    public function getPlayLength()
    {
        return $this->playLength;
    }
}
