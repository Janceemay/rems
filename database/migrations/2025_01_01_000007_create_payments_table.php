<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration {
    public function up() {
        Schema::create('payments', function(Blueprint $table){
            $table->id('payment_id');
            $table->foreignId('transaction_id')->constrained('transactions','transaction_id')->onUpdate('cascade')->onDelete('cascade');
            $table->date('due_date')->nullable();
            $table->decimal('amount_due',15,2)->nullable();
            $table->decimal('amount_paid',15,2)->default(0.00);
            $table->date('payment_date')->nullable();
            $table->enum('payment_status',['Pending','Paid','Overdue'])->default('Pending');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('payments');
    }
}
