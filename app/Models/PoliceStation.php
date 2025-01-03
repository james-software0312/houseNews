<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoliceStation extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'address',
        'status',
        'is_deleted',
        'deleted_at',
    ];
}
