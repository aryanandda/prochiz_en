<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('event_id')->unsigned()->nullable();
            $table->integer('recipe_category_id')->unsigned()->nullable();

            $table->text('name');
            $table->string('slug');
            $table->text('metadesc')->nullable();
            $table->longText('description')->nullable();
            $table->string('image')->nullable();
            $table->string('time')->nullable();
            $table->string('servings')->nullable();
            $table->string('type');
            $table->string('status');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');

            $table->foreign('event_id')
                  ->references('id')
                  ->on('events')
                  ->onDelete('set null');

            $table->foreign('recipe_category_id')
                  ->references('id')
                  ->on('recipe_categories')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipes');
    }
}
