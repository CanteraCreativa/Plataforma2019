<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImagesColumnToCreativeDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('creative_datas', function (Blueprint $table) {
            $table->string('profile_image')->nullable();
            $table->string('background_image')->nullable();
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
            $table->dropColumns([
                'profile_image',
                'background_image',
            ]);
        });
    }
}
