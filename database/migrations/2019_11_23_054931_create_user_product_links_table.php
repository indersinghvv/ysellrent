<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProductLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_product_links', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('product_id');
            $table->string('title');
            $table->string('slug');
            $table->string('author');
            $table->string('photo1');
            $table->string('photo2');
            $table->string('photo3');
            $table->string('category')->nullable();
            $table->integer('stock');
            $table->integer('sold_unit');
            $table->integer('original_price');
            $table->integer('sellingp_rice');
            $table->string('available_for');
            $table->boolean('shipping_service');
            $table->boolean('check_public');
            $table->boolean('check_product_ban');
            $table->boolean('check_linked')->default('1');
            $table->string('product_ban_reason');
            $table->boolean('condition');
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
        Schema::dropIfExists('user_product_links');
    }
}
