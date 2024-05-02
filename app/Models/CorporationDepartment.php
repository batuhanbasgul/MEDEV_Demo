<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorporationDepartment extends Model
{
    use HasFactory;

    protected $fillable = [
        'corporation_id',
        'company_id',
        'name',
        'person',
        'contact',
    ];
}
