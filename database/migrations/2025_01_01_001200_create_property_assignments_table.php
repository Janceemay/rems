<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyAssignmentsTable extends Migration {
    public function up() {
        Schema::create('property_assignments', function (Blueprint $table) {
            $table->id('assign_id');
            $table->unsignedBigInteger('agent_id');
            $table->unsignedBigInteger('property_id');
            $table->unsignedBigInteger('assigned_by')->nullable();
            $table->date('assigned_date')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('agent_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('property_id')->references('property_id')->on('properties')->onDelete('cascade');
            $table->foreign('assigned_by')->references('user_id')->on('users')->onDelete('set null');
        });
    }
    public function down() {
        Schema::dropIfExists('property_assignments');
    }
}
