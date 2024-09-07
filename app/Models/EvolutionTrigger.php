<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class EvolutionTrigger extends Model
{
    use HasFactory, Translatable;

    public $translatedAttributes = ['name'];
  
    protected $fillable = ['slug'];

    public function pokemon_evolutions()
    {
    return $this->hasMany(PokemonEvolution::class);
    }
  }
