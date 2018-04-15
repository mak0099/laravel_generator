<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModeratorsTable extends Migration
{
    public function up()
    {
        Schema::create('moderators', function (Blueprint $table) {
            $table->increments('id');
			$table->string('username');
			$table->string('email');
			$table->string('password');
            $table->softDeletes();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('moderators');
    }
}