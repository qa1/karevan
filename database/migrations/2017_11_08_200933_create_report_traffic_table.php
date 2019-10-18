<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportTrafficTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_traffic', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('modirkarevan_id')->index();
            $table->unsignedInteger('in')->default(0);
            $table->unsignedInteger('out')->default(0);
            $table->unsignedInteger('current_in')->default(0);
            $table->unsignedInteger('current_out')->default(0);
            $table->timestamps();

            $table->foreign('modirkarevan_id')->references('id')->on('modirkarevans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_traffic');
    }
}
