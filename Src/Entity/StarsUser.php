<?php
namespace Stars\Permission\Entity;
use Illuminate\Database\Eloquent\Model;
use Stars\Rbac\Entity\RoleEntity;

class StarsUser extends Model
{
    protected $fillable = ['username' ,'password' ,'status'];

    protected $with = [];

    /**
     * @param string $username
     * @param string $password
     * @param int $status
     */
    public function createUser(string $username, string $password,int $status ){

        return self::create([
            'username'=>$username,
            'password'=>$password ,
            'status'=>$status
        ]);
    }

    /**
     * 获取一个用户实例
     * @param $filter
     * @return mixed
     */
    public function info( $filter ){

        return self::where(function( $query ) use ($filter){
            if(is_numeric($filter)){
                $query->where('id', $filter );
            }elseif ( is_string( $filter)) {
                $query->where('username', $filter);
            }elseif( is_array($filter) ){
                $query->where($filter);
            }else{
                throw new \Exception("args error");
            }
        })->first();
    }

    /**
     * 获取一个用户实例
     * @param $filter
     * @return mixed
     */
    public function detail( $filter ){

        return self::with('roles')->where(function( $query ) use ($filter){
            if(is_numeric($filter)){
                $query->where('id', $filter );
            }elseif ( is_string( $filter)) {
                $query->where('username', $filter);
            }elseif( is_array($filter) ){
                $query->where($filter);
            }else{
                throw new \Exception("args error");
            }
        })->first();
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
     * 清除角色
     * @return int
     */
    public function clearRoles(){
        return $this->roles()->detach();
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
     * 是否包含角色
     * @param $roleName
     * @return mixed
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
     * 是否有权限
     * @param $permission
     * @return array|bool
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
            if( is_string( $canName)){
                return in_array( $canName , $array);
            }else if(is_array( $canName)){
                return !empty(array_intersect( $array, $canName ));
            }
        }
        return false;
    }

    /**
     * 包含角色
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles(){
        return $this->belongsToMany( StarsRole::class, 'stars_role_users', 'user_id','role_id'  );
    }
}
