<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

class Rounds extends Model
{
    protected $fillable = ['roundNumber'];

    public function competitions(): BelongsTo{
        return $this->belongsTo(Competitions::class, Rounds::class, 'c_name', 'name')->whereColumn('competitions.year', 'rounds.c_year');;
    }

    public function users(): BelongsToMany {
        return $this->belongsToMany(User::class, 'versenyzoks', 'r_id','u_email','id','email')->withTimestamps();
    }

    use HasFactory;
}
