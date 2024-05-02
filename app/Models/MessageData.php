<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageData extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'is_read',
        'image',
        'sender_name',
        'sender_department',
        'sender_id',
        'title',
        'context',
        'date',
        'time',
        'company_id',
    ];
}
