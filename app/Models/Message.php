<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_read',
        'sent_from',
        'sent_to',
        'is_private',
        'company_id',
        'title',
        'context',
    ];
}
