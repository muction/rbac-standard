<?php
namespace Stars\Permission\Database;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StarsPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create( 'stars_permissions' , function(Blueprint $table){
            $table->increments('id');
            $table->string('name','255')->unique('permission_name');
            $table->string('display_name','255');
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
        Schema::dropIfExists('stars_permissions');

    }
}
