<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotasTable extends Migration {
    public function up() {
        Schema::create('quotas', function (Blueprint $table) {
            $table->id('quota_id');
            $table->unsignedBigInteger('manager_id');
            $table->unsignedBigInteger('agent_id')->nullable();
            $table->unsignedBigInteger('team_id')->nullable();
            $table->decimal('target_sales', 15, 2)->default(0);
            $table->decimal('achieved_sales', 15, 2)->default(0);
            $table->date('period_start')->nullable();
            $table->date('period_end')->nullable();
            $table->enum('status', ['active', 'achieved', 'overdue', 'inactive'])->default('active');
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('manager_id')->references('manager_id')->on('sales_managers')->onDelete('cascade');
            $table->foreign('agent_id')->references('agent_id')->on('agents')->onDelete('set null');
            $table->foreign('team_id')->references('team_id')->on('teams')->onDelete('set null');
        });
    }

    public function down() {
        Schema::dropIfExists('quotas');
    }
}
