<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Ability extends Model
{
    use HasFactory, Translatable;
  
    public $translatedAttributes = ['name', 'description', 'effect'];

    public function pokemonVariety()
    {
    return $this->belongsToMany(PokemonVariety::class);
    }
  
  }
