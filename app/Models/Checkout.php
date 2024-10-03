<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use HasFactory;
    protected $fillable=[
        'no_order',
        'total_qty',
        'total_harga',
        'snap_token'
    ];
}
