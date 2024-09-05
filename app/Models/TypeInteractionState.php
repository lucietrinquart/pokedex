<?php

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeInteractionState extends Model
{
  use HasFactory;

  protected $fillable = ['name', 'multiplier'];

  // Définition des types de données des attributs
  protected $casts = [
    'name' => 'string',
    'multiplier' => 'float',
  ];
}