<?php

namespace App\Models\Api\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetailes extends Model
{
    use HasFactory;
    protected $table = 'order_detailes'; // تحديد اسم الجدول

    protected $fillable = [
        'order_id', 'product_id', 'quantity', 'total', 'state'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
