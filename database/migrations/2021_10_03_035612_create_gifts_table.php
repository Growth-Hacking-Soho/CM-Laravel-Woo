<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gifts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('key')->index();
            $table->string('sku', 200)->nullable();
            $table->string('order_email', 200)->nullable();
            $table->string('name', 200);
            $table->string('email', 256)->index()->nullable();
            $table->string('phone', 20)->nullable();
            $table->integer('order_id')->index();
            $table->string('message', 400)->nullable();
            $table->string('video', 256)->nullable();
            $table->integer('counter')->default(0);
            $table->enum('status', ['draft', 'send', 'open']);
            $table->dateTime('first_open_at')->nullable();
            $table->dateTime('last_open_at')->nullable();
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
        Schema::dropIfExists('gifts');
    }
}
