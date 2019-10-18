<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('melli', 25)->index()->nullable();
            $table->string('code', 25)->index()->nullable();
            $table->string('father')->nullable();
            $table->string('ban')->nullable();
            $table->enum('status', ['مراجعه نشده', 'داخل', 'خارج'])->default('مراجعه نشده');
            $table->unsignedInteger('city_id')->nullable();
            $table->unsignedInteger('modirkarevan_id')->nullable();
            $table->timestamps();

            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
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
        Schema::dropIfExists('persons');
    }
}
