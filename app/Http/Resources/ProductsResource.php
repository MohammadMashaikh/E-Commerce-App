<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $image = $this->getFirstMedia('product-image');

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description ?? '',
            'price' => $this->price,
            'stock' => $this->stock,
            'created date' => $this->created_at ? $this->created_at->format('d M Y') : '',
            'image'       => $image ? [
                    'id'  => $image->id,
                    'url' => $image->getUrl(),
                ] : null,
        ];
    }
}
