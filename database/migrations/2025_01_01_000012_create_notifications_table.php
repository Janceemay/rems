<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration {
    public function up() {
        Schema::create('notifications', function(Blueprint $table){
            $table->id('notif_id');
            $table->foreignId('user_id')->constrained('users','user_id')->onUpdate('cascade')->onDelete('cascade');
            $table->string('title',100)->nullable();
            $table->text('message')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down() {
        Schema::dropIfExists('notifications');
    }
}
