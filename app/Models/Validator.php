<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Validator extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $dates = [
        'update_time',
    ];

    protected $casts = [
        'jailed' => 'boolean',
        'uptime' => 'object',
    ];

    public function events()
    {
        return $this->hasMany(ValidatorEvent::class);
    }
}
