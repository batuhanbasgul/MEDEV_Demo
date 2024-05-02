<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'company_id',
        'corporation_id',
        'department_id',
        'name',
        'brand',
        'model',
        'serial_no',
        'qr_code',
        'qr_code_path',
        'spendable_count',
        'spendable_description',
        'note',
        'bill_no',
        'ern_code',
        'accessory',
    ];
}
