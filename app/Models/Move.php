<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;


class Move extends Model implements TranslatableContract
{
  use HasFactory, Translatable;

  public $translatedAttributes = ['name', 'description'];

  protected $fillable = ['accuracy', 'move_damage_class_id', 'power', 'pp', 'priority', 'type_id'];

  protected $casts = [
    'accuracy' => 'int',
    'power' => 'int',
    'pp' => 'int',
    'priority' => 'int',
  ];

  public function pokemon_evolutions()
{
    return $this->hasMany(PokemonEvolution::class);
}

public function Type()
{
    return $this->belongsTo(Type::class);
}
public function pokemon_learn_move()
{
    return $this->hasMany(PokemonLearnMove::class);
}

public function move_damage_class()
{
    return $this->belongsTo(MoveDamageClass::class);
}

}
