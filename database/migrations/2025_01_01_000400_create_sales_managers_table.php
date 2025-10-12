<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration {
    public function up() {
        Schema::create('sales_managers', function (Blueprint $table) {
            $table->id('manager_id');
            $table->unsignedBigInteger('user_id');
            $table->string('department')->nullable();
            $table->unsignedBigInteger('quota_id')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    public function down() {
        Schema::dropIfExists('clients');
    }
}
