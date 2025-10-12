<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration {
    public function up() {
        Schema::create('properties', function (Blueprint $table) {
            $table->id('property_id');
            $table->unsignedBigInteger('developer_id');
            $table->string('property_code')->unique();
            $table->string('property_type');
            $table->string('title');
            $table->string('location');
            $table->decimal('size', 10, 2)->nullable();
            $table->decimal('price', 15, 2)->nullable();
            $table->enum('status', ['available', 'sold', 'reserved', 'archived'])->default('available');
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->string('floor_plan')->nullable();
            $table->timestamps();

            $table->foreign('developer_id')->references('developer_id')->on('developers')->onDelete('cascade');
        });
    }

    public function down() {
        Schema::dropIfExists('properties');
    }
}
