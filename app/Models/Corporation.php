<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Corporation extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'name',
        'city',
        'province',
        'product_count',
        'device_count',
        'spendable_count'
    ];
}
