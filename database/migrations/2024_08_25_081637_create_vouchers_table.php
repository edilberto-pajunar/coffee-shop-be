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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string("code")->unique();
            $table->decimal("discount_amount", 8, 2)->nullable();
            $table->integer("discount_percentage")->nullable();
            $table->decimal("min_spend", 8, 2)->nullable();
            $table->decimal("max_discount_amount", 8, 2)->nullable();
            $table->timestamp("valid_from")->nullable();
            $table->timestamp("valid_until")->nullable();
            $table->integer("usage_limit")->nullable();
            $table->integer("used_count")->default(0);
            $table->boolean("is_active")->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
