<?php
namespace Rbac\Standard\Database;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RbacOrganize extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create( 'rbac_organizes' , function(Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger('parent_id')->default( 0);
            $table->string('name','125')->unique('name');
            $table->string('alias','125')->unique('alias');
            $table->string('display_name','255');
            $table->unsignedInteger('level')->default(1);
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
        Schema::dropIfExists('rbac_organizes');
    }
}
