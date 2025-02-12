<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Competitions extends Model
{
    protected $fillable = ['name','year','pointsForGoodAnswer','pointsForBadAnswer','poinstForEmptyAnswer'];
    
    public function rounds(): HasMany {
        return $this->hasMany(Rounds::class, 'c_name', 'name')->whereColumn('competitions.year', 'rounds.c_year');
    }

    use HasFactory;
}
