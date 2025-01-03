<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'rental_commune',
        'rental_address',
        'street_num',
        'int_num',
        'floor',
        'user_id',
        'status',
        'is_deleted',
        'deleted_at',
    ];
}
