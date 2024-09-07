<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PokemonLearnMove extends Model
{
    use HasFactory;

    protected $fillable = ['pokemon_variety_id', 'move_id', 'move_learn_method_id', 'game_version_id', 'level'];

    public function move()
{
    return $this->belongsTo(Move::class);
}

public function move_learn_methods()
{
    return $this->belongsTo(MoveLearnMethod::class);
}

public function game_version()
{
    return $this->belongsTo(GameVersion::class);
}

public function pokeon_variety()
{
    return $this->belongsTo(PokemonVariety::class);
}

}
