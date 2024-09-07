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
        Schema::create('move_learn_method_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->ForeignIdFor(App\Models\MoveLearnMethod::class)->constrained()->onDelete('cascade');
            $table->integer('locale');
            $table->integer('name');
            $table->integer('description')->nullable();
            $table->timestamps();

            $table->unique(['move_learn_method_id', 'locale']);
          });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('move_learn_method_translations');
    }
};
