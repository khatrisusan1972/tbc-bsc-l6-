<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class JsonUtility extends Model
{
    use HasFactory;

    public static function makeProductArray(string $file)
    {
        $string = file_get_contents($file);

        $productsJson = json_decode($string, true);


        $products = [];
        foreach ($productsJson as $product) {
            switch ($product['type']) {
                case "cd":
                    $cdproduct = new CdProduct(
                        $product['id'],
                        $product['title'],
                        $product['firstname'],
                        $product['mainname'],
                        $product['price'],
                        $product['playlength']
                    );
                    $products[] = $cdproduct;
                    break;
                case "book":
                    $bookproduct = new BookProduct(
                        $product['id'],
                        $product['title'],
                        $product['firstname'],
                        $product['mainname'],
                        $product['price'],
                        $product['numpages']
                    );
                    $products[] = $bookproduct;
                    break;
                case "game":
                    $gameproduct = new GameProduct(
                        $product['id'],
                        $product['title'],
                        $product['firstname'],
                        $product['mainname'],
                        $product['price'],
                        $product['pegi']
                    );
                    $products[] = $gameproduct;
                    break;
            }
        }
        return $products;
    }

    public static function deleteProductWithId(string $file, int $id)
    {
        $string = file_get_contents($file);

        $productsJson = json_decode($string, true);

        $products = [];
        foreach ($productsJson as $product) {
            if ($product['id'] != $id) {
                $products[] = $product;
            }
        }
        $json = json_encode($products);
        file_put_contents($file, $json);
    }

    public static function getProductWithId(string $file, int $id)
    {
        $string = file_get_contents($file);

        $productsJson = json_decode($string, true);

        foreach ($productsJson as $product) {
            if ($product['id'] == $id) {
                switch ($product['type']) {
                    case "cd":
                        $cdProduct = new CdProduct(
                            $product['id'],
                            $product['title'],
                            $product['firstname'],
                            $product['mainname'],
                            $product['price'],
                            $product['playlength']
                        );
                        return $cdProduct;
                    case "book":
                        $bookProduct = new BookProduct(
                            $product['id'],
                            $product['title'],
                            $product['firstname'],
                            $product['mainname'],
                            $product['price'],
                            $product['numpages']
                        );
                        return  $bookProduct;
                    case "game":
                        $gameProduct = new GameProduct(
                            $product['id'],
                            $product['title'],
                            $product['firstname'],
                            $product['mainname'],
                            $product['price'],
                            $product['pegi']
                        );
                        return  $gameProduct;
                }
            }
        }
    }

    public static function updateProductWithId(string $file, Request $request)
    {
        $product = JsonUtility::getProductWithId($file, $request->_id);

        $string = file_get_contents($file);

        $productsJson = json_decode($string, true);

        foreach ($productsJson as &$product) {
            if ($product['id'] == $request->_id) {
                $product['title'] = $request->title;
                $product['firstname'] = $request->firstName;
                $product['mainname'] = $request->surName;
                $product['price'] = $request->price;
                if ($product['type'] == 'cd') {
                    $product['playlength'] = $request->pages;
                }
                if ($product['type'] == 'book') {
                    $product['numpages'] = $request->pages;
                }
                if ($product['type'] == 'game') {
                    $product['pegi'] = $request->pages;
                }
            }
        }

        $json = json_encode($productsJson, JSON_PRETTY_PRINT);
        file_put_contents($file, $json);
    }

    public static function addNewProduct(string $file, string $producttype, string $fname, string $sname, string $title, string $pages, float $price)
    {
        $string = file_get_contents($file);

        $productsJson = json_decode($string, true);

        $ids = [];
        foreach ($productsJson as $product) {
            $ids[] = $product['id'];
        }
        rsort($ids);
        $newId = $ids[0] + 1;

        $products = [];
        foreach ($productsJson as $product) {
            $products[] = $product;
        }

        $newProduct = [];
        $newProduct['id'] = $newId;
        $newProduct['type'] = $producttype;
        $newProduct['title'] = $title;
        $newProduct['firstname'] = $fname;
        $newProduct['mainname'] = $sname;
        $newProduct['price'] = $price;

        if ($producttype == 'cd') {
            $newProduct['playlength'] = $pages;
        }
        if ($producttype == 'book') {
            $newProduct['numpages'] = $pages;
        }
        if ($producttype == 'game') {
            $newProduct['pegi'] = $pages;
        }

        $products[] = $newProduct;

        $json = json_encode($products);
        file_put_contents($file, $json);
    }
}
