<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelatedSubcategoryIdToSubCategoreiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sub_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('related_subcategory_id')->nullable()->after('category_id');
            // $table->foreign('related_subcategory_id')->references('id')->on('sub_categoreies')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sub_categoreies', function (Blueprint $table) {
            //
        });
    }
}
