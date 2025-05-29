<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foods extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'image', 'price', 'price_afterdiscount', 'percent', 'is_discount', 'categories_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id');
    }

}
