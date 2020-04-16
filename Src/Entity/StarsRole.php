<?php
namespace Stars\Permission\Entity;
use Illuminate\Database\Eloquent\Model;

class StarsRole extends Model
{
    protected $fillable = ['role_name' ,'role_display_name'];

    protected $with = ['permissions'];

    /**
     * 创建一个角色
     * @param string $roleName
     * @param string $roleDisplayName
     * @return mixed
     */
    public function createRole(string $roleName, string $roleDisplayName ){
        return self::create([
            'name'=>$roleName,
            'display_name'=>$roleDisplayName
        ]);
    }

    /**
     * 获取一个角色实例
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
     * 绑定用户
     * @param array $userIds
     */
    public function bindUsers(array $userIds){
        return $this->users()->attach( $userIds );
    }

    /**
     * 删除用户绑定
     * @param array $userIds
     * @return int
     */
    public function deleteUsers(array $userIds ){
        return $this->users()->detach( $userIds );
    }

    /**
     * 绑定权限
     * @param array $permissionIds
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
     * 包含用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(){
        return $this->belongsToMany( StarsUser::class , 'stars_role_users' ,'role_id' ,'user_id');
    }

    /**
     * 权限
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions(){
        return $this->belongsToMany( StarsPermission::class ,'stars_permission_roles','role_id' , 'permission_id' );
    }
}
