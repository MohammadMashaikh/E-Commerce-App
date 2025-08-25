<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductsResource;
use App\Interfaces\ProductRepositroryInterface;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProductsController extends Controller
{

    public $productRepo;

    public function __construct(ProductRepositroryInterface $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function list(Request $request)
    {
         $admin = auth('admin-api')->user();

        if (Gate::denies('view-products', $admin)) {
            return response()->json([
                'message' => 'Unauthorized',
                'success' => false
            ], 403);
        }


        $search = $request->search;
        $products = $this->productRepo->getAll($search);

        $products->appends(['search' => $search]);

        $data = $products->map(function ($item) {
            return new ProductsResource($item);
        });

        return response()->json([
            'message' => '',
            'success' => true,
            'data' => $data,
            'pagination' => [
            'current_page' => $products->currentPage(),
            'per_page'     => $products->perPage(),
            'total'        => $products->total(),
            'last_page'    => $products->lastPage(),
           ],
        ]);
    }



    public function show(Product $product)
    {

        $admin = auth('admin-api')->user();

        if (Gate::denies('view-products', $admin)) {
            return response()->json([
                'message' => 'Unauthorized',
                'success' => false
            ], 403);
        }

        return response()->json([
            'message' => '',
            'success' => true,
            'data' => new ProductsResource($product),
        ]);
    }



    public function store(Request $request)
    {
        $admin = auth('admin-api')->user();

        if (Gate::denies('manage-products', $admin)) {
            return response()->json([
                'message' => 'Unauthorized',
                'success' => false
            ], 403);
        }


        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:1',
            'stock' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048'
        ]);


        $data = collect($validatedData)->except('image')->toArray();    

        $product = $this->productRepo->store($data);

         if ($request->has('image')) {
            $product->addMediaFromRequest('image')->toMediaCollection('product-image');
         }


         return response()->json([
            'message' => 'Product Created Successfully',
            'success' => true,
            'data' => null,
        ]);
    }



    public function delete(Product $product)
    {
         $admin = auth('admin-api')->user();

        if (Gate::denies('manage-products', $admin)) {
            return response()->json([
                'message' => 'Unauthorized',
                'success' => false
            ], 403);
        }

        $product->delete();

        return response()->json([
            'message' => 'Product Deleted Successfully',
            'success' => true,
            'data' => null,
        ]);
    }
}
