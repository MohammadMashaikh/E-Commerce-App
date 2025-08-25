<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositroryInterface;
use App\Models\Product;

class ProductRepository implements ProductRepositroryInterface {


    public function getAll($search = null)
    {
        $query = Product::with('orderItems.order')->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                ->orWhereHas('orderItems.order', function ($q1) use ($search) {
                    $q1->where('status', 'like', '%' . $search . '%');
                });
            });
        }

        return $query->paginate(10);
    }


    public function getAllFiltered()
    {

        $products = Product::filters(request('sort'))
            ->when(request('search'), function ($q) {
                $q->where('name', 'like', '%' . request('search') . '%');
            })
            ->paginate(10);


        return $products;
    }


    public function find($id)
    {
        $product = Product::findOrFail($id);

        return $product;
    }

    public function store($data)
    {
        return Product::create($data);
    }

    public function update($data)
    {
        $product = $this->find($data['id']);

        if (!$product){
            return null;
        }

        $product->update([
            'name' => $data['name'],
            'description' => $data['description'] ?? '',
            'price' => $data['price'],
            'stock' => $data['stock']
        ]);

        return $product;
    }

    public function delete($id)
    {
        $product = $this->find($id);

        if (!$product) {
                return false;
            }

        $product->clearMediaCollection('product-image');

        return $product->delete();
    }

}