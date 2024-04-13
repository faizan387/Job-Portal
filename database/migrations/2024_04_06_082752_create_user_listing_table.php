<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * php artisan make:migration create_user_listing_table --create=user_listing
 */
class CreateUserListingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_listing', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('listing_id');
            $table->boolean('shortlisted')->default(false);
            $table->timestamps();
            // delete all entries with user id when user is deleted from user_lsiting table
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // delete all entries with listing id when listing is deleted from user_lsiting table
            $table->foreign('listing_id')->references('id')->on('listings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_listing');
    }
}
