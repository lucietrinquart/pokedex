<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pokemon_variety_type', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->ForeignIdFor(App\Models\Ability::class)->constrained()->onDelete('cascade');
            $table->ForeignIdFor(App\Models\PokemonVariety::class)->constrained()->onDelete('cascade');
            $table->boolean('is_hidden');
            $table->integer('slot');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pokemon_variety_type');
    }
};
