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
  Schema::create('type_translations', function (Blueprint $table) {
    $table->bigIncrements('id');
    $table->ForeignIdFor(App\Models\Type::class)->constrained()->onDelete('cascade');
    $table->string('locale')->index();
    $table->string('name');
    $table->timestamps();

    $table->unique(['type_id', 'locale']);
  });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_translations');
    }
};
