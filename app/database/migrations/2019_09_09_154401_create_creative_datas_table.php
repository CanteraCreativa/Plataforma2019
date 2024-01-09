<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateCreativeDatasTable.
 */
class CreateCreativeDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('creative_datas', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('gender')->nullable();
            $table->integer('age')->nullable();
            $table->string('studies')->nullable();
            $table->string('studies_where', 40)->nullable();
            $table->string('country')->nullable();
            $table->string('nationality')->nullable();
            $table->string('mercadopago_account')->nullable();

            $table->text('description', 500)->nullable();

            $table->unsignedBigInteger('account_id');
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('creative_datas');
    }
}
