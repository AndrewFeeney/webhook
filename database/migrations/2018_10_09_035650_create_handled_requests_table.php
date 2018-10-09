<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHandledRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('handled_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('method');
            $table->text('query')->nullable();
            $table->text('parameters')->nullable();
            $table->text('content')->nullable();
            $table->text('json')->nullable();
            $table->unsignedInteger('webhook_id');
            $table->foreign('webhook_id')->references('id')->on('webhooks');
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
        Schema::dropIfExists('handled_requests');
    }
}
