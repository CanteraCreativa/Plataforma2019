<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateContactMessagesTable.
 */
class CreateContactMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_messages', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('position');
            $table->string('how');
            $table->string('message', 1000);
            $table->boolean('receive_updates')->default(false);
            $table->boolean('read')->default(false);
            $table->integer('type')->unsigned()->default(\App\Enums\ContactMessageType::Brands);
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
        Schema::drop('contact_messages');
    }
}
