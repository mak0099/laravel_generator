<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('product_categories', function (Blueprint $table) {
            $table->increments('id');
			$table->string('product_name');
			$table->boolean('product_type');
            $table->softDeletes();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('product_categories');
    }
}

