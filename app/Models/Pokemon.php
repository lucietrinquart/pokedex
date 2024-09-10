<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;//importe pour faire le translate
use Laravel\Scout\Searchable;//importe pour faire la fonction recherche

class Pokemon extends Model implements TranslatableContract
{
  use HasFactory, Translatable, Searchable;

  // Liste des attributs traduits
  public $translatedAttributes = ['name', 'category'];

  // Liste des attributs autorisés pour la création et la mise à jour des données de manière massive
  protected $fillable = ['has_gender_differences', 'is_baby', 'is_legendary', 'is_mythical'];

  // Définition des types de données des attributs
  protected $casts = [
    'has_gender_differences' => 'boolean',
    'is_baby' => 'boolean',
    'is_legendary' => 'boolean',
    'is_mythical' => 'boolean',
  ];
  public function varieties()
{
  return $this->hasMany(PokemonVariety::class); //de un a plusieur (par exemple, "Pikachu") peut avoir plusieurs variétés (par exemple, "Pikachu normal", "Pikachu déguisé", etc.).
}

public function defaultVariety()
{
  return $this->hasOne(PokemonVariety::class)
              ->where('is_default', true);
}

public function toSearchableArray(): array//permet de faire une recherche plus exhaustive
{
  return $this->load(['varieties', 'varieties.types'])
              ->toArray();
}

public function catchByUsers()
{
  return $this->belongsToMany(User::class);
}
public function pokemon_evolutions_as_trade()
{
    return $this->hasMany(PokemonEvolution::class, 'trade_species_id');
}

public function pokemon_evolutions_as_party()
{
    return $this->hasMany(PokemonEvolution::class, 'party_species_id');
}
}