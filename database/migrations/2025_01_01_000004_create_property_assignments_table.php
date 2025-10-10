<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyAssignmentsTable extends Migration {
    public function up() {
        Schema::create('property_assignments', function(Blueprint $table){
            $table->id('assign_id');
            $table->foreignId('agent_id')->constrained('users','user_id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('property_id')->constrained('properties','property_id')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamp('assigned_date')->useCurrent();
        });
    }

    public function down() {
        Schema::dropIfExists('property_assignments');
    }
}
