<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatabaseManagementsTable extends Migration
{
    public function up()
    {
        Schema::create('database_managements', function (Blueprint $table) {
            $table->increments('id');
			$table->string('name');
            $table->softDeletes();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('database_managements');
    }
}