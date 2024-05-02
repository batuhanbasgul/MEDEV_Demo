<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDataMin extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'email',
        'company_id',
        'image'
    ];
}
