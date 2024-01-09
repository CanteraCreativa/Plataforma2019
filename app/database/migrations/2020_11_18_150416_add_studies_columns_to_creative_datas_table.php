<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStudiesColumnsToCreativeDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('creative_datas', function (Blueprint $table) {
            $table->unsignedBigInteger('career_id')->nullable();
            $table->unsignedBigInteger('study_level_id')->nullable();

            $table->foreign('career_id')->references('id')->on('careers');
            $table->foreign('study_level_id')->references('id')->on('study_levels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('creative_datas', function (Blueprint $table) {
            //
        });
    }
}
