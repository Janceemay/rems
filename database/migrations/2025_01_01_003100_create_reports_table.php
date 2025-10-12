<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration {
    public function up() {
        Schema::create('reports', function (Blueprint $table) {
            $table->id('report_id');
            $table->unsignedBigInteger('generated_by')->nullable();
            $table->string('report_type');
            $table->string('report_format')->default('pdf');
            $table->string('file_path')->nullable();
            $table->date('period_start')->nullable();
            $table->date('period_end')->nullable();
            $table->dateTime('date_generated')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('generated_by')->references('user_id')->on('users')->onDelete('set null');
        });
    }

    public function down() {
        Schema::dropIfExists('reports');
    }
}
