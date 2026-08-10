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
        Schema::create('pricing_lanes', function (Blueprint $table) {
            $table->id();

            $table->string('origin');
            $table->string('destination');

            $table->unsignedInteger('distance_km');

            $table->decimal('price', 10, 2);

            $table->boolean('is_firm')->default(false);
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->unique(['origin', 'destination']);
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_lanes');
    }
};