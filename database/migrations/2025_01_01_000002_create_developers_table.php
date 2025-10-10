<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevelopersTable extends Migration {
    public function up() {
        Schema::create('developers', function(Blueprint $table){
            $table->id('developer_id');
            $table->string('developer_name',100);
            $table->string('contact_person',100)->nullable();
            $table->string('contact_number',20)->nullable();
            $table->string('email',100)->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('developers');
    }
}
