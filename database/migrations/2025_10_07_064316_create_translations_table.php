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
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->morphs('translatable'); // translatable_type, translatable_id
            $table->string('locale', 10); // en, mn, zh
            $table->string('field'); // title, content, excerpt, etc.
            $table->longText('value');
            $table->timestamps();

            $table->index(['translatable_type', 'translatable_id', 'locale']);
            $table->unique(['translatable_type', 'translatable_id', 'locale', 'field']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('translations');
    }
};
