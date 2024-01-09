<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWinnersColumnToAnnouncementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->unsignedBigInteger('winner_first')->nullable();
            $table->unsignedBigInteger('winner_second')->nullable();
            $table->unsignedBigInteger('winner_third')->nullable();

            $table->foreign('winner_first')->references('id')->on('submissions')->onDelete('set null');
            $table->foreign('winner_second')->references('id')->on('submissions')->onDelete('set null');
            $table->foreign('winner_third')->references('id')->on('submissions')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropColumn([
                'winner_first',
                'winner_second',
                'winner_third',
            ]);
        });
    }
}
