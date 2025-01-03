<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'token',
        'guest_email',
        'guest_first_name',
        'guest_last_name',
        'guest_birthday',
        'guest_birth_city',
        'guest_birth_country',
        'guest_nationality',
        'guest_address',
        'id_type',
        'id_num',
        'id_date',        
        'id_authority',
        'passport',
        'guest_message',
        'status',
        'is_deleted',
        'deleted_at',
    ];
}
