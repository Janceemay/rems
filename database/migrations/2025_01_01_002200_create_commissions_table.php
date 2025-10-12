<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommissionsTable extends Migration {
    public function up() {
        Schema::create('commissions', function (Blueprint $table) {
            $table->id('commission_id');
            $table->unsignedBigInteger('transaction_id');
            $table->unsignedBigInteger('agent_id');
            $table->decimal('percentage', 5, 2)->default(0);
            $table->decimal('amount', 15, 2)->default(0);
            $table->enum('approval_status', ['pending', 'approved', 'rejected', 'on_hold'])->default('pending');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->date('date_generated')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('transaction_id')->references('transaction_id')->on('transactions')->onDelete('cascade');
            $table->foreign('agent_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('approved_by')->references('user_id')->on('users')->onDelete('set null');
        });
    }

    public function down() {
        Schema::dropIfExists('commissions');
    }
}
