<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'corporation_id',
        'corporation_name',
        'department_id',
        'department_name',
        'product_id',
        'product_name',
        'device_id',
        'device_name',
        'device_brand',
        'device_model',
        'device_serial_no',
        'personel_id',
        'personel_name',
        'description',
        'verifier_name',
        'verifier_tel',
        'is_verified',
        'record_no_to',
        'record_no_from',
        'transactions',
        'controller_id',
        'controller_name',
        'control_date',
        'service_in_date',
        'service_out_date',
        'calibration_tag_date',
        'note'
    ];
}
