<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration {
    public function up() {
        Schema::create('reports', function(Blueprint $table){
            $table->id('report_id');
            $table->foreignId('generated_by')->constrained('users','user_id')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('report_type',['Property','Sales','Financial','AgentPerformance','ClientPayment','Commission'])->nullable();
            $table->enum('report_format',['CSV','Excel','Word','PDF'])->nullable();
            $table->string('file_path',255)->nullable();
            $table->timestamp('date_generated')->useCurrent();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('reports');
    }
}
