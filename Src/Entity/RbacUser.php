<?php
namespace Rbac\Standard\Traits;
use Illuminate\Support\Facades\Hash;
use Rbac\Standard\Entity\RbacGroup;
use Rbac\Standard\Entity\RbacRole;
use Illuminate\Database\Eloquent\Model;

/**
 * 用户
 * Trait RbacUser
 * @package Rbac\Standard\Traits
 */
class RbacUser extends Model
{
    protected $fillable = ['username' ,'password' ,'status'];
    /**
     * 新增一个用户
     * @param $username
     * @param $password
     * @param $status
     * @return mixed
     */
    public function storage( $username, $password , $status ){
        return self::create(['username'=> $username  ,'password'=> Hash::make( $password) ,'status'=> $status ]);
    }

    /**
     * 删除一个用户
     * @param $id
     * @return mixed
     */
    public function remove($id){
        return self::where('id', $id)->delete();
    }

    /**
     * 查找一个用户
     * @param $id
     * @return mixed
     */
    public function info( $id ){
        return self::where('id' , $id)->first();
    }

    /**
     * 是否有角色
     * @param string|array $roleName
     * @return bool
     */
    public function hasRole( $roleName ){
        if(is_string($roleName)){
            return  $this->roles->contains('name', $roleName );
        }elseif (is_array( $roleName)){
            return !empty(array_intersect( array_column( $this->roles->toArray() ,'name' ) , $roleName ));
        }
        return false;
    }

    /**
     * 是否有组
     * @param $groupName
     * @return bool
     */
    public function hasGroup( $groupName ){
        if(is_string($groupName)){
            return  $this->groups->contains('name', $groupName );
        }elseif (is_array( $groupName)){
            return !empty(array_intersect( array_column( $this->groups->toArray() ,'name' ) , $groupName ));
        }
        return false;
    }

    /**
     * 是否具有某个权限
     * @param string|array $canName
     * @return bool
     */
    public function can( $canName ){
        $permissions = $this->roles->toArray();
        if($permissions){
            $permissions = array_column($permissions ,'permissions');
            $array = [];
            if($permissions){
                foreach ($permissions as $permission){
                    $array = array_merge( $array, array_column( $permission, 'name') );
                }
            }
            if( is_string( $permission)){
                return in_array( $canName , $array);
            }else if(is_array( $canName)){
                return !empty(array_intersect( $array, $canName ));
            }
        }
        return false;
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
     * 添加组关联
     * @param array $roleId
     * @return mixed
     */
    public function bindGroups(array $roleIds ){
        return $this->groups()->attach( $roleIds );
    }

    /**
     * 删除组关联
     * @param array $ids
     * @return int
     */
    public function deleteGroups(array $ids ){
        return $this->groups()->detach( $ids );
    }

    /**
     * 关联关系
     * @return mixed
     */
    public function roles(){
        return $this->belongsToMany( RbacRole::class, 'rbac_role_users', 'user_id','role_id'  );
    }

    /**
     * 关联关系
     * @return mixed
     */
    public function groups(){
        return $this->belongsToMany( RbacGroup::class, 'rbac_group_users', 'user_id','group_id'  );
    }
}
