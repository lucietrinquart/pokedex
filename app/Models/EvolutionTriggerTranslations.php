<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvolutionTriggerTranslations extends Model
{
    use HasFactory;
    
  protected $fillable = ['name', 'evolution_trigger_id'];
}
