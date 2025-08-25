<?php

namespace App\Http\Controllers;

use App\Interfaces\ProductRepositroryInterface;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    private $productRepo;

    public function __construct(ProductRepositroryInterface $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function list(Request $request)
    {
        $search = $request->search;

        $products = $this->productRepo->getAllFiltered();

        return view('home', compact('products'));
    }
}
