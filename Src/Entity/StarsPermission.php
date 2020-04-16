<?php

namespace Stars\Permission\Entity;

use Illuminate\Database\Eloquent\Model;

class StarsPermission extends Model
{
    protected $fillable = [ 'name' , 'display_name'];

    /**
     * 创建权限
     * @param $permissionName
     * @param $displayName
     * @return mixed
     */
    public function createPermission( $permissionName, $displayName ){
        return self::create([
            'name'=>$permissionName ,
            'display_name'=>$displayName
        ]);
    }

    /**
     * 获取一个权限实例
     * @param $filter
     * @return mixed
     */
    public function info( $filter ){

        return self::where(function( $query ) use ($filter){
            if(is_numeric($filter)){
                $query->where('id', $filter );
            }elseif ( is_string( $filter)) {
                $query->where('role_name', $filter);
            }elseif( is_array($filter) ){
                $query->where($filter);
            }else{
                throw new \Exception("args error");
            }
        })->first();
    }

    /**
     * 追加到一个角色
     * @param int $roleId
     */
    public function appendToRole(int $roleId ){
        return $this->roles()->attach( $roleId );
    }

    /**
     * 多对多
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles(){
        return $this->belongsToMany( StarsRole::class ,'stars_permission_roles', 'permission_id','role_id' );
    }

}
