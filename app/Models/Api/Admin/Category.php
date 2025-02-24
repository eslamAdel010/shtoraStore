<?php

namespace App\Models\Api\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories'; 

    protected $fillable = [
        'category', 
        'image'
    ]; 
      // ✅ علاقة التصنيف بالمنتجات (تصنيف يحتوي على عدة منتجات)
      public function products()
      {
          return $this->hasMany(Product::class,'category_id');
      }
}
