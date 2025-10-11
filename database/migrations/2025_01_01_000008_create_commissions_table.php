<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommissionsTable extends Migration {
    public function up() {
        Schema::create('commissions', function(Blueprint $table){
            $table->id('commission_id');
            $table->foreignId('transaction_id')->constrained('transactions','transaction_id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('agent_id')->constrained('users','user_id')->onUpdate('cascade')->onDelete('cascade');
            $table->decimal('percentage',5,2)->default(0.00);
            $table->decimal('amount',15,2)->default(0.00);
            $table->enum('approval_status',['Pending','Approved','Released'])->default('Pending');
            $table->foreignId('approved_by')->nullable()->constrained('users','user_id')->onUpdate('cascade')->onDelete('set null');
            $table->timestamp('date_generated')->useCurrent();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('commissions');
    }
}
