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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->string('supplier_name');
            $table->string('supplier_tax_id');
            $table->decimal('net_amount', 15, 2);
            $table->decimal('vat_amount', 15, 2);
            $table->decimal('gross_amount', 15, 2);
            $table->string('currency')->default('UAH');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->date('issue_date')->nullable();
            $table->date('due_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
