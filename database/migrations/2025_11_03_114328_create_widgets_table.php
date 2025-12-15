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
        Schema::create('widgets', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // Unique identifier for widget (e.g., 'contact-cta', 'stats-counter')
            $table->string('name'); // Display name
            $table->string('type'); // Widget type (html, stats, cta, gallery, etc.)
            $table->json('content')->nullable(); // Widget content/configuration (JSON)
            $table->string('area')->default('sidebar'); // Widget area (sidebar, footer, header, custom)
            $table->integer('order')->default(0); // Display order
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('widgets');
    }
};
