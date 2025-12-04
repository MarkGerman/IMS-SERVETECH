<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'system_organization_name',
        'system_phone_1',
        'system_phone_2',
        'system_phone_3',
        'currency',
        'system_address',
        'email',
        'logo',
    ];
}
