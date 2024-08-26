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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId("order_id")->references("id")->on("orders")->onDelete("cascade");
            $table->foreignId("user_id")->references("id")->on("users")->onDelete("cascade");
            $table->decimal("amount", 8 ,2);
            $table->string("currency")->default("PHP");
            $table->string("payment_method");
            $table->enum("status", ["pending", "completed", "failed"])->default("pending");
            $table->string("transaction_id")->unique();
            $table->timestamp("payment_date")->nullable();
            $table->string("qr_code")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
