<?php

namespace App\Models\Api\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders'; // تحديد اسم الجدول

    protected $fillable = [
        'name', 
        'phone', 
        'other_phone', 
        'adress', 
        'note'
    ];
}
