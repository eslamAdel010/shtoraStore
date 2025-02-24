<?php

namespace App\Models\Api\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'phone',
        'other_phone',
        'adress',
        'status',
        'note',
    ];
}
