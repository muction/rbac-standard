<?php
namespace Rbac\Standard\Database;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RbacPermissionTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create( 'rbac_permission_types' , function(Blueprint $table){
            $table->increments('id');
            $table->string('name','255')->unique('name');
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
        Schema::dropIfExists('rbac_permission_types');

    }
}
