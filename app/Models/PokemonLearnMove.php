<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PokemonLearnMove extends Model
{
    use HasFactory;

    protected $fillable = ['pokemon_variety_id', 'move_id', 'move_learn_method_id', 'game_version_id', 'level'];
}
