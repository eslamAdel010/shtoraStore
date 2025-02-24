<?php

namespace App\Models\Api\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'description', 
        'image', 
        'price', 
        'price_after', 
        'stock',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class ,'category_id');
        
    }
    

}
