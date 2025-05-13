<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instrumen extends Model
{
    protected $fillable = [
        'sasaran_strategis',
        'indikator_kinerja',
        'aktivitas'
    ];
}
