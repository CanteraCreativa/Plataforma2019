<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateSubmissionsTable.
 */
class CreateSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submissions', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');

            $table->timestamps();

            $table->unsignedBigInteger('inscription_id');
            $table->foreign('inscription_id')->references('id')->on('creative_data_announcement')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('submissions');
    }
}
