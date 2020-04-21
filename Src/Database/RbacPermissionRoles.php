<?php
namespace Rbac\Standard\Database;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RbacPermissionRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create( 'rbac_permission_roles' , function(Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger('permission_id');
            $table->unsignedInteger('role_id') ;
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
        Schema::dropIfExists('rbac_permission_roles');
    }
}
