<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'name',
        'photo',
        'category_id',
        'variant_id',
        'stock',
        'price',
        'status'
    ];

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function variant()
    {
        return $this->hasOne(Variant::class, 'id', 'variant_id');
    }
}
