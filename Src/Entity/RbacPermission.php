<?php
namespace Rbac\Standard\Entity;
use Illuminate\Database\Eloquent\Model;

/**
 * 权限
 * Class RbacPermission
 * @package Rbac\Standard\Entity
 */
class RbacPermission extends Model
{
    protected $fillable = [ 'type' , 'name' ,'display_name'];

    /**
     * 新增一个权限
     * @param $type
     * @param $name
     * @param $displayName
     * @return mixed
     */
    public function storage($type, $name, $displayName ){
        return self::create(['type'=>$type , 'name'=>$name ,'display_name'=>$displayName]);
    }

    /**
     * 更新一个权限
     * @param $id
     * @param array $update
     * @return mixed
     */
    public function modify( $id, array $update ){
        return self::where('id', $id)->update($update);
    }

    /**
     * 删除一个权限
     * @param $id
     * @return mixed
     */
    public function remove($id){
        return self::where('id', $id)->delete();
    }

    /**
     * 查找一个权限
     * @param $id
     * @return mixed
     */
    public function info( $id ){
        return self::where('id' , $id)->first();
    }

    /**
     * 追加到一个角色
     * @param int $roleId
     * @return mixed
     */
    public function appendToRole(int $roleId ){
        return $this->roles()->attach( $roleId );
    }

    /**
     * 多对多
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles(){
        return $this->belongsToMany( StarsRole::class ,'rbac_permission_roles', 'permission_id','role_id' );
    }
}
