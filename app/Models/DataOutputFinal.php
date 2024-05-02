<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataOutputFinal extends Model
{
    use HasFactory;

    protected $fillable = [
        'order',
        'device_name',
        'device_brand',
        'device_model',
        'device_serial_no',
        'device_ern_code',
        'record_no_to',
        'record_no_from',
        'corporation_name',
        'service_in_date',
        'service_out_date',
        'transactions',
        'personel_name',
        'transaction_date',
        'department',
        'verifier_name',
        'verifier_tel',
        'accessory',
        'controller_name',
        'control_date',
        'bill_no',
        'calibration_tag_date',
        'note',
    ];
}
