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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('phone');
            $table->string('email');
            $table->string('website');
            $table->text('description');
            $table->string('image');
            $table->enum('status', ['active', 'inactive'])->default("active");
            $table->double('lat');
            $table->double('lng');
            $table->time('opening_hours'); // Changed to time
            $table->time('closing_hours'); // Changed to time
            $table->boolean("open_24_hours");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
