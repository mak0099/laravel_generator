<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrudsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cruds', function (Blueprint $table) {
            $table->increments('id');
            $table->string('crud_name');
            $table->string('crud_view_name');
            $table->string('table_name');
            $table->string('fa_icon')->nullable();
            $table->boolean('soft_delete')->default(false);
            $table->boolean('data_table')->default(true);
            $table->integer('paginate')->default(0);
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
        Schema::dropIfExists('cruds');
    }
}
