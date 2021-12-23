<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportedBenchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reported_benches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bench')->references('id')->on('benches');
            $table->foreignId('reason')->references('id')->on('report_reasons');
            $table->integer('amount_reported');
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
        Schema::dropIfExists('reported_benches');
    }
}
