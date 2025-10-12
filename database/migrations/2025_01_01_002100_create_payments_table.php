<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration {
    public function up() {
        Schema::create('payments', function (Blueprint $table) {
            $table->id('payment_id');
            $table->unsignedBigInteger('transaction_id');
            $table->date('due_date')->nullable();
            $table->decimal('amount_due', 15, 2)->default(0);
            $table->decimal('amount_paid', 15, 2)->default(0);
            $table->date('payment_date')->nullable();
            $table->enum('payment_status', ['pending', 'partial', 'paid', 'overdue', 'approved'])->default('pending');
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('transaction_id')->references('transaction_id')->on('transactions')->onDelete('cascade');
        });
    }

    public function down() {
        Schema::dropIfExists('payments');
    }
}
