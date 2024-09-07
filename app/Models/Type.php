<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Type extends Model implements TranslatableContract
{
    use HasFactory, Translatable;
  
    public $translatedAttributes = ['name', 'local'];
  
    protected $fillable = ['sprite_url'];
    public function pokemon_Variety()
    {
      return $this->belongsToMany(PokemonVariety::class);
    }

    public function interactTo(){
        $this->belongsToMany(Type::class, 'type_interaction', 'from_type_id', 'to_type_id')
                ->withPivot('type_interaction_state_id');  
    }

    public function interactedBy(){
        $this->belongsToMany(Type::class, 'type_interaction', 'to_type_id', 'from_type_id')
                ->withPivot('type_interaction_state_id');  
    }
  }