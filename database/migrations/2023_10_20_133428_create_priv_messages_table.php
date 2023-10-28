<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('priv_messages', function (Blueprint $table) {
            $table->id();
            $table->text('priv_message');
            $table->unsignedBigInteger('priv_talk_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('priv_talk_id')->references('id')->on('priv_talks')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('priv_messages');
    }
};
