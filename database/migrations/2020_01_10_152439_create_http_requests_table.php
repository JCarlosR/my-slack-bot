<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHttpRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('http_requests', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->text('request_url');
            $table->text('request_content');
            $table->text('request_method');

            $table->text('response');

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
        Schema::dropIfExists('http_requests');
    }
}
