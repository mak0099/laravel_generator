<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablesTable extends Migration
{
    public function up()
    {
        Schema::create('tables', function (Blueprint $table) {
            $table->increments('id');
			$table->string('name');
			$table->boolean('auto_increament')->default(true);
			$table->boolean('user_tracking')->default(false);
			$table->boolean('softdelete')->default(false);
			$table->boolean('timestamp')->default(true);
			$table->boolean('active')->default(true);
			$table->integer('database_id')->unsigned()->nullable();
			$table->foreign('database_id')->references('id')->on('databases')->onDelete('cascade');
			$table->bigInteger('creator_user_id')->unsigned()->nullable();
			$table->foreign('creator_user_id')->references('id')->on('users')->onDelete('cascade');
			$table->bigInteger('updator_user_id')->unsigned()->nullable();
			$table->foreign('updator_user_id')->references('id')->on('users')->onDelete('cascade');
			$table->integer('order_column');
            $table->softDeletes();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('tables');
    }
}