<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'card_number',
        'session_datetime', 
        'end_datetime',
        'state',
        'center_code'
    ];

    protected $casts = ['datetime' => 'datetime', 'end_datetime' => 'datetime'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
