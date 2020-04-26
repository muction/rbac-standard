<?php
namespace Rbac\Standard\Entity;
use Illuminate\Database\Eloquent\Model;

/**
 * 组
 * Class RbacGroup
 * @package Rbac\Standard\Entity
 */
class RbacGroup extends Model
{
    protected $fillable = ['name' ,'display_name'];

    /**
     * 新增一个组
     * @param $name
     * @param $displayName
     * @return mixed
     */
    public function storage( $name, $displayName ){
        return self::create(['name'=>$name ,'display_name'=>$displayName]);
    }

    /**
     * 更新一个组
     * @param $id
     * @param array $update
     * @return mixed
     */
    public function modify( $id, array $update ){
        return self::where('id', $id)->update($update);
    }

    /**
     * 删除一个组
     * @param $id
     * @return mixed
     */
    public function remove($id){
        return self::where('id', $id)->delete();
    }

    /**
     * 查找一个组
     * @param $id
     * @return mixed
     */
    public function info( $id ){
        return self::where('id' , $id)->first();
    }

    /**
     * 添加角色关联
     * @param array $roleId
     * @return mixed
     */
    public function bindRoles(array $roleIds ){
        return $this->roles()->attach( $roleIds );
    }

    /**
     * 删除指定角色
     * @param array $ids
     * @return int
     */
    public function deleteRoles(array $ids ){
        return $this->roles()->detach( $ids );
    }

    /**
     * 关联关系
     * @return mixed
     */
    public function roles(){
        return $this->belongsToMany( RbacRole::class, 'rbac_group_roles', 'group_id','role_id'  );
    }
}
