<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'polytechnic_name',
        'fathers_name',
        'mothers_name',
        'roll',
        'registration_number',
        'image',
        'status',
    ];

    protected $dates = ['created_at', 'updated_at'];
}

