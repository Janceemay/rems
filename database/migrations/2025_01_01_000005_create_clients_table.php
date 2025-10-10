<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration {
    public function up() {
        Schema::create('clients', function(Blueprint $table){
            $table->id('client_id');
            $table->foreignId('user_id')->constrained('users','user_id')->onUpdate('cascade')->onDelete('cascade');
            $table->string('current_job',100)->nullable();
            $table->string('financing_type',100)->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('clients');
    }
}
