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
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')
                  ->constrained()
                  ->cascadeOnDelete();
            $table->string('disk')->default('public');     // disk lưu trữ
            $table->string('path');                        // đường dẫn tương đối trên disk
            $table->string('original_name')->nullable();   // tên gốc
            $table->string('extension', 16)->nullable();   // phần mở rộng
            $table->unsignedBigInteger('size')->nullable();// byte
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};
