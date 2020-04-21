<?php
namespace Rbac\Standard\Entity;
use Illuminate\Database\Eloquent\Model;

/**
 * 角色
 * Class RbacRole
 * @package Rbac\Standard\Entity
 */
class RbacRole extends Model
{
    protected $fillable = ['name' ,'display_name'];

    /**
     * 新增一个角色
     * @param $name
     * @param $displayName
     * @return mixed
     */
    public function storage( $name, $displayName ){
        return self::create(['name'=>$name ,'display_name'=>$displayName]);
    }

    /**
     * 更新一个角色
     * @param $id
     * @param array $update
     * @return mixed
     */
    public function modify( $id, array $update ){
        return self::where('id', $id)->update($update);
    }

    /**
     * 删除一个角色
     * @param $id
     * @return mixed
     */
    public function remove($id){
        return self::where('id', $id)->delete();
    }

    /**
     * 查找一个角色
     * @param $id
     * @return mixed
     */
    public function info( $id ){
        return self::where('id' , $id)->first();
    }

    /**
     * 绑定权限
     * @param array $permissionIds
     * @return mixed
     */
    public function bindPermissions(array $permissionIds ){
        return $this->permissions()->attach( $permissionIds );
    }

    /**
     * 解绑权限
     * @param array $permissions
     * @return int
     */
    public function deletePermissions(array $permissions){
        return $this->permissions()->detach( $permissions );
    }

    /**
     * 权限
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions(){
        return $this->belongsToMany( RbacPermission::class ,'rbac_permission_roles','role_id' , 'permission_id' );
    }
}
