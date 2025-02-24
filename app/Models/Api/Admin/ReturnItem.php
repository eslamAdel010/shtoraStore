<?php

namespace App\Models\Api\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnItem extends Model
{
    use HasFactory;
    protected $table = 'return_items'; // تحديد اسم الجدول

    protected $fillable = [
        'order_id', 
        'notes'
    ];
    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
