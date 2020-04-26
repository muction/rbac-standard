<?php
namespace Rbac\Standard\Entity;
use Illuminate\Database\Eloquent\Model;

/**
 * 权限
 * Class RbacPermissionType
 * @package Rbac\Standard\Entity
 */
class RbacPermissionType extends Model
{
    protected $fillable = [ 'name' ,'display_name'];

    /**
     * 新增一个权限
     * @param $type
     * @param $name
     * @param $displayName
     * @return mixed
     */
    public function storage( $name, $displayName ){
        return self::create(['name'=>$name ,'display_name'=>$displayName]);
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
    public function appendToPermission(int $roleId ){
        return $this->permissions()->attach( $roleId );
    }

    /**
     * 多对多
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions(){
        return $this->hasMany( RbacPermission::class ,'type','id');
    }
}
