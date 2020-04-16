<?php
namespace Stars\Permission\Database;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StarsUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 数据表可以生成后自行扩展字段
        Schema::create( 'stars_users' , function(Blueprint $table){
            $table->increments('id');
            $table->string('username','255')->unique('username');
            $table->string('password','256') ;
            $table->tinyInteger('status')->default(1)->comment('1可用，其他自定义');
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
        //
        Schema::dropIfExists('stars_users');
    }
}
