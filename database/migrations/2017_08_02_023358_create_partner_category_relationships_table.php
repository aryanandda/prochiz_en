<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartnerCategoryRelationshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partner_category_relationships', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('partner_id')->unsigned();
            $table->integer('partner_category_id')->unsigned();

            $table->foreign('partner_id')
                  ->references('id')
                  ->on('partners')
                  ->onDelete('cascade');

            $table->foreign('partner_category_id')
                  ->references('id')
                  ->on('partner_categories')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partner_category_relationships');
    }
}
