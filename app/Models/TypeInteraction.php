<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class TypeInteraction extends Pivot
{
    use HasFactory;

    protected $table = 'type_interactions';

    public function typeInteractionState()
{
    return $this->belongsTo(TypeInteractionState::class, 'type_interaction_state_id');
}
public function testtypeinteractionTo(){
  return $this->belongsTo(Type::class, 'from_type_id');
      }

  public function testtypeinteractionBy(){
      return $this->belongsTo(Type::class, 'to_type_id');
  }

}