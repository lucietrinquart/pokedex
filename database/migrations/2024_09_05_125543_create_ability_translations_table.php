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
        Schema::create('ability_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->ForeignIdFor(App\Models\Ability::class)->constrained()->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('name')->nullable();
            $table->string('effect')->nullable();
            $table->string('description');
            $table->timestamps();
        
            $table->unique(['ability_id', 'locale']);
          });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ability_translations');
    }
};
