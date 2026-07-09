<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_products', function (Blueprint $table) {
            $table->id();

            $table->foreignId('member_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('product_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('order_id')->nullable();

            $table->timestamps();

            $table->unique(['member_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_products');
    }
};