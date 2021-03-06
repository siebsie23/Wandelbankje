<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikedBenches extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liked_benches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('bench')->references('id')->on('benches')->onDelete('cascade');;
            $table->boolean('like')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('liked_benches');
    }
}
