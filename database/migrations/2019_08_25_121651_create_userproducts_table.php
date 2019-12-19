<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserproductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userproducts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->string('title');
            $table->string('slug');
            $table->string('author');
            $table->string('photo1');
            $table->string('photo2');
            $table->string('photo3');
            $table->string('category');
            $table->integer('stock'); 
            $table->integer('sold_unit')->default('0'); 
            $table->integer('original_price');
            $table->integer('selling_price');
            $table->string('available_for');
            $table->boolean('shipping_service');

            $table->boolean('delete_status')->default('0');
            $table->boolean('check_public')->default('1');
            $table->boolean('check_product_ban')->default('0');
            $table->boolean('check_linked')->default('0');
            $table->string('product_ban_reason')->default('nothing');;
            $table->string('condition');
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
        Schema::dropIfExists('userproducts');
    }
}
