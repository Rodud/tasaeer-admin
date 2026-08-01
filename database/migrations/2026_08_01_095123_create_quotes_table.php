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
        Schema::create('quotes', function (Blueprint $table) {
    
            $table->id();
    
            $table->string('ref')->unique();
    
            // بيانات العميل
            $table->string('name');
            $table->string('company')->nullable();
            $table->string('phone');
            $table->string('email')->nullable();
    
            // بيانات الرحلة
            $table->string('origin');
            $table->string('destination');
    
            // بيانات الشحنة
            $table->string('truck_type');
            $table->string('cargo_type');
            $table->string('weight_band');
            $table->integer('truck_count')->default(1);
    
            $table->date('load_date')->nullable();
            $table->string('readiness')->nullable();
    
            $table->text('notes')->nullable();
    
            // التسعير
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('vat', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
    
            $table->string('price_source')->default('حساب');
    
            // الحالة
            $table->enum('status', [
                'جديد',
                'قيد التسعير',
                'أُرسل العرض',
                'مؤكد',
                'مرفوض'
            ])->default('جديد');
    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
