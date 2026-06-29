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
        Schema::create('landing_page_components', function (Blueprint $table) {

            $table->id();

            $table->foreignId('section_id')
                ->constrained('landing_page_sections')
                ->cascadeOnDelete();

            // kalau layout 2 kolom
            $table->unsignedTinyInteger('column')->default(1);

            // text image button dll
            $table->string('type');

            $table->json('content')->nullable();

            $table->integer('sort_order')->default(0);

            $table->boolean('is_visible')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_page_components');
    }
};
