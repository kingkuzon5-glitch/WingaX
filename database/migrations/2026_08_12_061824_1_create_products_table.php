<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2);
            $table->decimal('discount_price', 12, 2)->nullable();
            $table->string('location')->nullable();
            $table->enum('availability', ['in_stock', 'limited', 'out_of_stock'])->default('in_stock');
            $table->string('reference')->unique();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_deal')->default(false);
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->json('specs')->nullable();
            $table->timestamps();

            $table->index(['status', 'is_featured']);
            $table->index(['status', 'is_deal']);
            $table->index(['status', 'created_at']);
            $table->index('store_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
