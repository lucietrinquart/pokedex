<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PokemonEvolution extends Model
{
    use HasFactory;

    protected $fillable = ['pokemon_veriety_id', 'evolves_to_id', 'held_item_id', 'item_id', 'know_move_id', 'know_move_type_id', 'party_type_id', 'party_species_id', 'trade_species_id', 'evolution_trigger_id', 'gender', 'location', 'min_affection', 'min_happiness', 'min_level', 'need_overwold_rain', 'relative_physical_stats', 'time_of_day', 'turn_upside_down'];

    protected $casts = [
      'turn_upside_down' => 'boolean',
      'need_overwold_rain' => 'boolean',
      'gender' => 'boolean'
    ];

    public function evolution_triggers()
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

    public function items_held()
    {
        return $this->belongsTo(Item::class, 'held_item_id');
    }
    
    public function items_id()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
