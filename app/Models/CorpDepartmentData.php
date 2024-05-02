<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorpDepartmentData extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'corporation_name',
        'company_id',
        'name',
        'person',
        'contact',
    ];
}
