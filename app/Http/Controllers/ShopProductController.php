<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JsonUtility;
use App\Models\BookProduct;
use App\Models\CdProduct;
use App\Models\GameProduct;

class ShopProductController extends Controller
{
    public function index()
    {
        $books = [];
        $cds = [];
        $games = [];

        $products = JsonUtility::makeProductArray("products.json");

        foreach ($products as $product) {
            if ($product instanceof BookProduct) {
                $books[] = $product;
            }
            if ($product instanceof CdProduct) {
                $cds[] = $product;
            }
            if ($product instanceof GameProduct) {
                $games[] = $product;
            }
        }

        return view("welcome", [
            "pageTitle" => "Component - 2 working with views and data",
            "books" => $books,
            "cds" => $cds,
            "games" => $games,
        ]);
    }

    public function show($id)
    {
        $product = JsonUtility::getProductWithId("products.json", $id);
        $title = "";
        if ($product instanceof CdProduct) {
            $title = "CD";
        } else if ($product instanceof BookProduct) {
            $title = "Book";
        } elseif ($product instanceof GameProduct) {
            $title = "Game";
        }

        return view("products", [
            "pageTitle" => $title,
            "title" => $title,
            "product" => $product
        ]);
    }

    public function create()
    {
        return view("create-products", [
            "pageTitle" => "Products | Create"
        ]);
    }

    public function store(Request $request)
    {

        $this->validateRequest($request);

        JsonUtility::addNewProduct("products.json", $request->producttype, $request->firstName, $request->surName, $request->title, $request->pages, $request->price);

        return redirect("/");
    }

    public function edit($id)
    {
        $product = JsonUtility::getProductWithId("products.json", $id);

        $title = "";
        if ($product instanceof CdProduct) {
            $title = "CD";
        } else if ($product instanceof BookProduct) {
            $title = "Book";
        } elseif ($product instanceof GameProduct) {
            $title = "Game";
        }

        return view("products", [
            "pageTitle" => "Products | Update $title",
            "title" => $title,
            "product" => $product
        ]);
    }

    public function update(Request $request)
    {
        JsonUtility::updateProductWithId("products.json", $request);

        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        JsonUtility::deleteProductWithId("products.json", $request->_id);

        return redirect()->back();
    }

    private function validateRequest(Request $request)
    {
        $this->validate($request, [
            "producttype" => "required",
            "firstName" => "required",
            "surName" => "required",
            "title" => "required",
            "pages" => "required",
            "price" => "required",
        ]);
    }
}
