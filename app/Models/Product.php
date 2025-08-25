<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['name', 'description', 'price', 'stock'];
    protected $casts = [
        'created_at' => 'date'
    ];

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }



    public function scopeFilters($query, $filter)
    {
        switch ($filter) {
            case 'oldest':
                return $query->orderBy('created_at', 'asc');

            case 'newest':
                return $query->orderBy('created_at', 'desc');

            case 'low_high':
                return $query->orderBy('price', 'asc');

            case 'high_low':
                return $query->orderBy('price', 'desc');

            default:
                return $query;
        }
    }



}
