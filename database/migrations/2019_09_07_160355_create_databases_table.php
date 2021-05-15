<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatabasesTable extends Migration
{
    public function up()
    {
        Schema::create('databases', function (Blueprint $table) {
            $table->increments('id');
			$table->string('name');
			$table->boolean('user_table')->default(true);
			$table->boolean('user_permission')->default(false);
			$table->boolean('active')->default(true);
			$table->bigInteger('creator_user_id')->unsigned()->nullable();
			$table->foreign('creator_user_id')->references('id')->on('users')->onDelete('cascade');
			$table->bigInteger('updator_user_id')->unsigned()->nullable();
			$table->foreign('updator_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('databases');
    }
}