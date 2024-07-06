<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->text('description');
                $table->longText('content');
                $table->unsignedBigInteger('menu_id')->nullable();
                $table->integer('price')->nullable();
                $table->integer('price_sale')->nullable();
                $table->integer('active');
                $table->string('thumb')->nullable(); 
                $table->string('slug')->nullable();
                $table->timestamps();
                $table->unsignedBigInteger('created_by')->nullable();
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade')->onUpdate('cascade');
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
                $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['menu_id']);
        });
        Schema::dropIfExists('products');
    }
}
