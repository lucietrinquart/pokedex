<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;


class PokemonVariety extends Model implements TranslatableContract
{
  use HasFactory, Translatable;

  public $translatedAttributes = ['name', 'description', 'form_name'];

  protected $fillable = ['pokemon_id', 'is_default', 'cry_url', 'height', 'weight', 'base_experience', 'base_stats_hp', 'base_stats_attack', 'base_stats_defense', 'base_stats_special_attack', 'base_stats_special_defense', 'base_stats_speed'];

  protected $casts = [
    'is_default' => 'boolean',
  ];
  
public function pokemon()
{
  return $this->belongsTo(Pokemon::class); //(par exemple, "Pikachu déguisé") appartient à un Pokémon spécifique (par exemple, "Pikachu").
}

public function sprites()
{
  return $this->hasOne(PokemonVarietySprite::class);
}

public function Ability()
{
  return $this->belongsToMany(Ability::class);
}

public function type()
{
  return $this->belongsToMany(Type::class);
}

}
