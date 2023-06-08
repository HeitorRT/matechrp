<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained();
            $table->enum('payment_method', ['cartao', 'boleto', 'pix', 'deposito'])->nullable();
            $table->enum('status', ['pago', 'aberto', 'vencido', 'inadimplente', 'reembolsado', 'cancelado'])->nullable();
            $table->integer('intstallment_number');
            $table->decimal('payment_value')->default(0);
            $table->dateTime('expiration_at')->nullable();
            $table->dateTime('expiration_original_at')->nullable();
            $table->dateTime('payday_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('installments');
    }
};
