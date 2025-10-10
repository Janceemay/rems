<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotasTable extends Migration {
    public function up() {
        Schema::create('quotas', function(Blueprint $table){
            $table->id('quota_id');
            $table->foreignId('manager_id')->constrained('users','user_id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('agent_id')->constrained('users','user_id')->onUpdate('cascade')->onDelete('cascade');
            $table->decimal('target_sales',15,2)->nullable();
            $table->decimal('achieved_sales',15,2)->default(0.00);
            $table->date('period_start')->nullable();
            $table->date('period_end')->nullable();
            $table->enum('status',['Ongoing','Met','Not Met'])->default('Ongoing');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('quotas');
    }
}
