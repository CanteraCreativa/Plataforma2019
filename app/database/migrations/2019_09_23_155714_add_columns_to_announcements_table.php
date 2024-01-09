<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToAnnouncementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->string('company');
            $table->integer('total_prize')->unsigned();
            $table->date('start_date');
            $table->date('end_date');
            $table->date('results_date');
            $table->text('short_description');
            $table->text('context')->nullable();
            $table->text('challenge')->nullable();
            $table->text('tips')->nullable();
            $table->integer('first_prize')->unsigned();
            $table->integer('second_prize')->unsigned();
            $table->integer('third_prize')->unsigned();
            $table->text('format')->nullable();
            $table->text('criteria')->nullable();
            $table->text('alignments')->nullable();
            $table->string('rules_file');
            $table->string('image_thumbnail');
            $table->string('image_banner');
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
                'company',
                'total_prize',
                'start_date',
                'end_date',
                'results_date',
                'short_description',
                'context',
                'challenge',
                'tips',
                'first_prize',
                'second_prize',
                'third_prize',
                'format',
                'criteria',
                'alignments',
                'rules_file',
                'image_thumbnail',
                'image_banner'
            ]);
        });
    }
}
