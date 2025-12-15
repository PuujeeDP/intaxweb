<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop the old check constraint
        DB::statement('ALTER TABLE service_sections DROP CONSTRAINT IF EXISTS service_sections_type_check');

        // Add new check constraint with 'content' type
        DB::statement("ALTER TABLE service_sections ADD CONSTRAINT service_sections_type_check CHECK (type IN ('tab', 'accordion', 'content'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the constraint with content
        DB::statement('ALTER TABLE service_sections DROP CONSTRAINT IF EXISTS service_sections_type_check');

        // Add back the old constraint without 'content'
        DB::statement("ALTER TABLE service_sections ADD CONSTRAINT service_sections_type_check CHECK (type IN ('tab', 'accordion'))");
    }
};
