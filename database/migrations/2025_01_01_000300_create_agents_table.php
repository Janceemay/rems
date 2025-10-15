<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentsTable extends Migration {
    public function up() {
        Schema::create('agents', function (Blueprint $table) {
            $table->id('agent_id');
            $table->unsignedBigInteger('user_id');
            $table->string('rank')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('email')->nullable();
            $table->unsignedBigInteger('team_id')->nullable();
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    public function down() {
        Schema::dropIfExists('clients');
    }
}
