<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PokemonTranslation extends Model
{
  use HasFactory;

  protected $fillable = ['from_type_id', 'to_type_id', 'type_interaction_state_id'];

  public function type_interaction_states()
{
  return $this->belongsTo(TypeInteractionState::class);
}
}
