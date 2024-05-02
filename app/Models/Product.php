<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'corporation_id',
        'company_id',
        'name',
        'device_count',
        'spendable_count',
        'start_date',
        'end_date',
        'is_active'
    ];
}
