<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsercarddetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usercarddetails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('userid');
            $table->decimal('cardnumber');
            $table->decimal('cardmonth');
            $table->decimal('cardyear');
            $table->string('cardholdername');
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
        Schema::dropIfExists('usercarddetails');
    }
}
