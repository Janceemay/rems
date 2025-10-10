<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration {
    public function up() {
        Schema::create('properties', function(Blueprint $table){
            $table->id('property_id');
            $table->foreignId('developer_id')->nullable()->constrained('developers','developer_id')->onUpdate('cascade')->onDelete('set null');
            $table->string('property_code',50)->unique()->nullable();
            $table->enum('property_type',['Condominium','House','Lot','Apartment','Townhouse']);
            $table->string('title',150)->nullable();
            $table->text('location')->nullable();
            $table->decimal('size',10,2)->nullable();
            $table->decimal('price',15,2)->nullable();
            $table->enum('status',['Available','Reserved','Sold','Archived'])->default('Available');
            $table->text('description')->nullable();
            $table->string('image_url',255)->nullable();
            $table->string('floor_plan',255)->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('properties');
    }
}
