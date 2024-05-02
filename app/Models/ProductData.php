<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductData extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'corporation_name',
        'company_id',
        'type',
        'device_count',
        'spendable_count',
        'start_date',
        'end_date',
        'is_active'
    ];
}
