<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeGenderColumnTypeInCreativeDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('creative_datas', function (Blueprint $table) {
            $table->integer('gender_new')->nullable()->after('gender');
        });

        $datas = \App\Models\CreativeData::all();
        foreach($datas as $data) {
            switch ($data->gender) {
                case 'Male':
                    $data->gender_new = \App\Enums\UserGender::Male();
                    break;
                case 'Female':
                    $data->gender_new = \App\Enums\UserGender::Female();
                    break;
                default:
                    $data->gender_new = null;
                    break;
            }
        }
        Schema::table('creative_datas', function(Blueprint $table)
        {
            $table->dropColumn('gender');
        });

        Schema::table('creative_datas', function(Blueprint $table)
        {
            $table->renameColumn('gender_new', 'gender');
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
            $table->string('gender')->nullable();
        });
    }
}
