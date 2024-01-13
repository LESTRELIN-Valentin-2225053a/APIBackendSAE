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
        Schema::create('save_media_position', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('investigation_id')->unsigned();
            $table->bigInteger('media_id')->unsigned();
            $table->double('posY');
            $table->double('posX');

            $table->primary(['user_id', 'investigation_id', 'media_id']);

            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('investigation_id')->references('investigation_id')->on('investigations');
            $table->foreign('media_id')->references('media_id')->on('media');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('save_media_position');
    }
};
