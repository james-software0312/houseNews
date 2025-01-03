<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'property_id',
        'owner_first_name',
        'owner_last_name',
        'owner_birthday',
        'owner_birth_city',
        'owner_birth_country',
        'owner_address',
        'start_date',
        'end_date',
        'rental_commune',
        'rental_address',
        'street_num',
        'int_num',
        'floor',
        'guest_email',
        'pdf_filename',
        'status',
        'is_deleted',
        'deleted_at',
    ];
}
