<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Item extends Model implements TranslatableContract
{
    use HasFactory, Translatable;
  
    public $translatedAttributes = ['name', 'description'];
  
    protected $fillable = ['sprite_url'];

    public function pokemon_evolutions_held()
{
    return $this->hasMany(PokemonEvolution::class, 'held_item_id');
}

public function pokemon_evolutions_item()
{
    return $this->hasMany(PokemonEvolution::class, 'item_id');
}
  
}