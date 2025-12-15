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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained()->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('menu_items')->onDelete('cascade');

            // Item type: 'page', 'post', 'category', 'custom', 'external'
            $table->string('type')->default('custom');

            // For linked items (page_id, post_id, category_id)
            $table->unsignedBigInteger('linkable_id')->nullable();
            $table->string('linkable_type')->nullable();

            // Custom URL (for type='custom' or 'external')
            $table->string('url')->nullable();

            // Display properties
            $table->integer('order')->default(0);
            $table->string('target')->default('_self'); // _self, _blank
            $table->string('icon')->nullable();
            $table->string('css_class')->nullable();

            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Indexes for performance
            $table->index(['menu_id', 'parent_id', 'order']);
            $table->index(['linkable_id', 'linkable_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
