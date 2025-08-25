<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Interfaces\ProductRepositroryInterface;
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

        $products = $this->productRepo->getAll($search);

        $products->appends(['search' => $search]);

        return view('admin.products.index', compact('products'));
    }



    public function create()
    {
        return view('admin.products.create');
    }



    public function store(Request $request)
    {
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


        return redirect()->route('admin.products.list')->with('success', 'Product Added Successfully');

    }



    public function edit()
    {
        return view('admin.products.edit');
    }


    public function update($id, Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:1',
            'stock' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048'
        ]);


        $data = collect($validatedData)->except('image')->toArray();
        $data['id'] = $id;
        
        $product = $this->productRepo->update($data);

        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }


         if ($request->hasFile('image')) {

            $product->clearMediaCollection('product-image');
            $product->addMediaFromRequest('image')->toMediaCollection('product-image');
        }


        return redirect()->route('admin.products.list')->with('success', 'Product Updated Successfully');
    }




    public function delete($id)
    {
        $this->productRepo->delete($id);
        return redirect()->back()->with('success', 'Product Deleted Successfully');
    }

    
}