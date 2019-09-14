<?php

use App\Models\Column;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColumnsTable extends Migration
{
    public function up()
    {
        Schema::create('columns', function (Blueprint $table) {
            $table->increments('id');
			$table->string('name');
			$table->enum('type', Column::get_laravel_types())->default(Column::get_laravel_default_type());
			$table->string('length')->nullable();
			$table->string('default')->nullable();
			$table->enum('attribute', Column::get_attributes())->nullable();
			$table->boolean('nullable')->default(true);
			$table->boolean('unique')->default(false);
			$table->boolean('unsigned')->default(false);
			$table->boolean('primary')->default(false);
			$table->boolean('index')->default(false);
			$table->boolean('auto_increament')->default(false);
			$table->string('comment')->nullable();
			$table->enum('mme_type', Column::get_mme_types())->nullable();
			$table->enum('on_delete', Column::get_on_deletes())->default(Column::get_default_on_delete());
			$table->boolean('active')->default(true);
			$table->integer('foreign_table_id')->unsigned()->nullable();
			$table->foreign('foreign_table_id')->references('id')->on('tables')->onDelete('cascade');
			$table->integer('foreign_column_id')->unsigned()->nullable();
			$table->foreign('foreign_column_id')->references('id')->on('columns')->onDelete('cascade');
			$table->integer('database_id')->unsigned();
			$table->foreign('database_id')->references('id')->on('databases')->onDelete('cascade');
			$table->integer('table_id')->unsigned();
			$table->foreign('table_id')->references('id')->on('tables')->onDelete('cascade');
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
        Schema::dropIfExists('columns');
    }
}
