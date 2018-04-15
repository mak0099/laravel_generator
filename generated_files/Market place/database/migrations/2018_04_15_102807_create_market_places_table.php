<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarketPlacesTable extends Migration
{
    public function up()
    {
        Schema::create('market_places', function (Blueprint $table) {
            $table->increments('id');
			$table->string('name');
			$table->string('email');
            $table->softDeletes();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('market_places');
    }
}