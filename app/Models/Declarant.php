<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Declarant extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name',
        'last_name',
        'pec_email',
        'birthday',
        'birth_city',
        'birth_country',
        'nationality',
        'address',
        'avatar',
        'user_id',
        'is_owned',
        'status',
        'is_deleted',
        'deleted_at',
    ];
}
