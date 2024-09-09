<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PokemonEvolution extends Model
{
    use HasFactory;

    protected $fillable = [
        'pokemon_variety_id', 'evolves_to_id', 'held_item_id', 'item_id', 'know_move_id', 
        'know_move_type_id', 'party_type_id', 'party_species_id', 'trade_species_id', 
        'evolution_trigger_id', 'gender', 'location', 'min_affection', 'min_happiness', 
        'min_level', 'need_overworld_rain', 'relative_physical_stats', 'time_of_day', 
        'turn_upside_down'
    ];

    protected $casts = [
        'turn_upside_down' => 'boolean',
        'need_overworld_rain' => 'boolean',
        'gender' => 'boolean'
    ];

    public function evolution_trigger()
    {
        return $this->belongsTo(EvolutionTrigger::class);
    }

    public function trade_species()
    {
        return $this->belongsTo(Pokemon::class, 'trade_species_id');
    }
    
    public function party_species()
    {
        return $this->belongsTo(Pokemon::class, 'party_species_id');
    }

    public function held_item()
    {
        return $this->belongsTo(Item::class, 'held_item_id');
    }
    
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function know_move_type()
    {
        return $this->belongsTo(Type::class, 'know_move_type_id');
    }

    public function party_type()
    {
        return $this->belongsTo(Type::class, 'party_type_id');
    }

    public function pokemon_variety()
    {
        return $this->belongsTo(PokemonVariety::class, 'pokemon_variety_id');
    }

    public function evolves_to()
    {
        return $this->belongsTo(PokemonVariety::class, 'evolves_to_id');
    }
}