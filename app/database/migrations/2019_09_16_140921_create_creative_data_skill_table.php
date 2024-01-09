<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreativeDataSkillTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('creative_data_skill', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->integer('level')->unsigned()->default(1);

            $table->unsignedBigInteger('skill_id');
            $table->unsignedBigInteger('creative_data_id');

            $table->foreign('skill_id')->references('id')->on('skills')->onDelete('cascade');
            $table->foreign('creative_data_id')->references('id')->on('creative_datas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('creative_data_skill');
    }
}
