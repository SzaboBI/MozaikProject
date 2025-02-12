<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Versenyzok extends Pivot
{
    protected $fillable = ['u_email', 'r_id'];
    
    use HasFactory;
}
