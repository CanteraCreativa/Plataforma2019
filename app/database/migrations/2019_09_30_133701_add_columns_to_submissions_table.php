<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->integer('state')->unsigned()->default(\App\Enums\SubmissionState::Pending);

            $table->string('image_file');
            $table->string('submission_file');
            $table->text('description')->nullable();

            $table->boolean('legal_external')->default(false);
            $table->text('legal_external_details')->nullable();

            $table->boolean('legal_author')->default(false);
            $table->boolean('legal_human_figures')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->dropColumn([
                'state',
                'image_file',
                'submission_file',
                'description',
                'legal_external',
                'legal_external_details',
                'legal_author',
                'legal_human_figures'
            ]);
        });
    }
}
