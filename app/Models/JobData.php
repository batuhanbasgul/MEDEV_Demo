<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobData extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'job_title',
        'job_context',
        'assigned_from',
        'assigned_to',
        'company_id',
        'serial_number',
        'is_multiple_user',
        'status',
        'is_success',
        'unsuccess_reason',
        'start_date',
        'end_date',
        'users'
    ];
}
