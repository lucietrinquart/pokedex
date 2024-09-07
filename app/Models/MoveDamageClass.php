<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class MoveDamageClass extends Model
{
    use HasFactory;

    public $translatedAttributes = ['name', 'description'];

    public function move()
{
    return $this->hasMany(Move::class);
}
}
