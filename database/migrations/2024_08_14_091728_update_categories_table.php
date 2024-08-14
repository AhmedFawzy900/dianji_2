<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('image')->nullable();
            $table->string('cover_image')->nullable()->after('image'); // Add cover_image field
            $table->decimal('commission', 5, 2)->nullable()->after('cover_image'); // Ensure commission is nullable
            $table->string('zones')->nullable()->after('description'); // Ensure zones is nullable
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('cover_image');
            $table->dropColumn('image');
            $table->dropColumn('commission');
            $table->dropColumn('zones');
        });
    }
}
