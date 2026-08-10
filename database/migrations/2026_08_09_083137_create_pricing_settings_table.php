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
        Schema::create('pricing_settings', function (Blueprint $table) {
            $table->id();

            $table->decimal('fixed_sar', 10, 2)->default(754);
            $table->decimal('per_km_sar', 10, 2)->default(1.57);

            $table->decimal('road_factor', 8, 4)->default(1.12);
            $table->decimal('export_factor', 8, 4)->default(1.95);
            $table->decimal('import_factor', 8, 4)->default(1.80);

            $table->decimal('vat_rate', 5, 2)->default(15);
            $table->decimal('rounding_sar', 10, 2)->default(50);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_settings');
    }
};