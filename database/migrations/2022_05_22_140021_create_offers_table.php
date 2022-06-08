<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('title');
            $table->double('price');
            $table->unsignedBigInteger('category_id');   /* On a créé la column category_id */
            $table->foreign('category_id')->references('id')->on('categories');
            $table->unsignedBigInteger('user_id');   /* On a créé la column category_id */
            $table->foreign('user_id')->references('id')->on('users');
            /* la column qu'on a créé elle reference a id dans la table categories */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');

    }
}
