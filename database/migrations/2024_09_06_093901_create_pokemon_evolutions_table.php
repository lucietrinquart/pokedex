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
        Schema::create('pokemon_evolutions', function (Blueprint $table) {
            $table->id();
            $table->ForeignIdFor(App\Models\PokemonVariety::class, "pokemon_variety_id")->constrained()->onDelete('cascade');
            $table->ForeignIdFor(App\Models\PokemonVariety::class, "evolves_to_id");
            $table->ForeignIdFor(App\Models\Item::class, "held_item_id")->nullable();
            $table->ForeignIdFor(App\Models\Item::class)->nullable();
            $table->ForeignIdFor(App\Models\Move::class, "known_move_id")->nullable();
            $table->ForeignIdFor(App\Models\Type::class, 'known_move_type_id')->nullable();
            $table->ForeignIdFor(App\Models\Type::class, "party_type_id")->nullable();
            $table->ForeignIdFor(App\Models\Pokemon::class, "party_species_id")->nullable();
            $table->ForeignIdFor(App\Models\Pokemon::class, "trade_species_id")->nullable();
            $table->ForeignIdFor(App\Models\EvolutionTrigger::class);
            $table->boolean('gender')->nullable();
            $table->string('location')->nullable();
            $table->integer('min_affection')->nullable();
            $table->integer('min_happiness')->nullable();
            $table->integer('min_level')->nullable();
            $table->boolean('need_overworld_rain')->default(false);
            $table->integer('relative_physical_stats')->nullable();
            $table->string('time_of_day')->nullable();
            $table->boolean('turn_upside_down')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pokemon_evolutions');
    }
};
