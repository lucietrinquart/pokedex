<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class MoveLearnMethod extends Model
{
    use HasFactory, Translatable;
  
    public $translatedAttributes = ['name', 'description'];

    public function pokemon_learn_move()
{
    return $this->hasMany(PokemonLearnMove::class);
}
  }