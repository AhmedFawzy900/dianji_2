<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubcategoryLevel4Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subcategory_level4', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subcategory_level3_id');
            $table->string('name', 100)->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('cover_image')->nullable();
            $table->tinyInteger('status')->nullable()->default('1')->comment('1- Active , 0- InActive');
            $table->tinyInteger('is_featured')->nullable()->default('0');
            $table->foreign('subcategory_level3_id')->references('id')->on('subcategory_level3')->onDelete('cascade');
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
        Schema::dropIfExists('subcategory_level4');
    }
}
