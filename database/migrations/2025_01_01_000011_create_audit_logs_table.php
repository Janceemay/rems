<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditLogsTable extends Migration {
    public function up() {
        Schema::create('audit_logs', function(Blueprint $table){
            $table->id('log_id');
            $table->foreignId('user_id')->nullable()->constrained('users','user_id')->onUpdate('cascade')->onDelete('set null');
            $table->string('action',100);
            $table->string('target_table',100)->nullable();
            $table->unsignedBigInteger('target_id')->nullable();
            $table->timestamp('timestamp')->useCurrent();
            $table->text('remarks')->nullable();
        });
    }

    public function down() {
        Schema::dropIfExists('audit_logs');
    }
}
