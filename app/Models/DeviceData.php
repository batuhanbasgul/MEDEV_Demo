<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceData extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'product_name',
        'company_id',
        'corporation_name',
        'name',
        'brand',
        'model',
        'serial_no',
        'qr_code',
        'qr_code_path',
        'department_name',
        'spendable_count',
        'spendable_description',
        'department_contact',
        'note',
        'bill_no',
        'ern_code',
        'accessory',
    ];
}
