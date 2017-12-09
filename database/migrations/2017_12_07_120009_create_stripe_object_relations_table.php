<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStripeObjectRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stripe_object_relations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('stripe_object_id')->index();
            $table->morphs('related');
            $table->string('tag')->index();
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
        Schema::drop('stripe_object_relations');
    }
}
