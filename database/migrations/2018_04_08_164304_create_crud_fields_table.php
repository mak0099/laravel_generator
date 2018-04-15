<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrudFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crud_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('crud_id')->unsigned();
            $table->string('field_name');
            $table->string('field_view_name');
            $table->string('html_type');
            $table->string('db_type');
            $table->boolean('searchable')->default(true);
            $table->boolean('fillable')->default(true);
            $table->boolean('editable')->default(true);
            $table->boolean('primary')->default(false);
            $table->boolean('in_form')->default(true);
            $table->boolean('in_index')->default(true);
            $table->boolean('in_view')->default(true);
            $table->timestamps();

            $table->foreign('crud_id')->references('id')->on('cruds')->onDelete('cascade');
            // $table->primary(['crud_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crud_fields');
    }
}
