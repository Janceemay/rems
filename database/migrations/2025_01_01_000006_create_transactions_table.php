<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration {
    public function up() {
        Schema::create('transactions', function(Blueprint $table){
            $table->id('transaction_id');
            $table->foreignId('client_id')->constrained('clients','client_id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('agent_id')->constrained('users','user_id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('property_id')->constrained('properties','property_id')->onUpdate('cascade')->onDelete('restrict');
            $table->enum('status',['Pending','Under Review','Approved','Cancelled','Completed'])->default('Pending');
            $table->timestamp('request_date')->useCurrent();
            $table->timestamp('approval_date')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('transactions');
    }
}
