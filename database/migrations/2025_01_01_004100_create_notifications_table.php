<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration {
    public function up() {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id('notif_id');
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->text('message');
            $table->string('type')->nullable(); // e.g., transaction, property, system
            $table->boolean('is_read')->default(false);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    public function down() {
        Schema::dropIfExists('notifications');
    }
}
