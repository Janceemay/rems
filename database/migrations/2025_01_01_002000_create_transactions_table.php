<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration {
    public function up() {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id('transaction_id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('agent_id');
            $table->unsignedBigInteger('property_id');
            $table->enum('status', ['pending', 'approved', 'completed', 'canceled'])->default('pending');
            $table->enum('approval_stage', ['agent_review', 'manager_review', 'finance_verification', 'final_approval'])->nullable();
            $table->date('request_date')->nullable();
            $table->date('approval_date')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->text('notes')->nullable();
            $table->decimal('total_amount', 15, 2)->nullable();
            $table->timestamps();

            $table->foreign('client_id')->references('client_id')->on('clients')->onDelete('cascade');
            $table->foreign('agent_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('property_id')->references('property_id')->on('properties')->onDelete('cascade');
        });
    }

    public function down() {
        Schema::dropIfExists('transactions');
    }
}
