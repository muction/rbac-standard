### StarsPermission 权限

### 一、初始化
    
    运行命令： php artisan starsPermission:init 

### 二、方法说明

##### StarsUser

 
    1、新增一个用户 
    createUser(string $username, string $password,int $status )
    
    2、获取一个实例
    info( $filter) 可以传递id，名称
    
    3、绑定角色
    bindRoles( array $roleIds ) 批量绑定角色
    
    4、清空角色
    clearRoles()  
    
    5、解绑指定角色
    deleteRoles( array $roleIds )
    
    6、是否有角色授权
    hasRole( $roleName )  您可以传递一个或数组多个形式判断
    
    7、是否有操作权限
    can( $canName ) 您可以传递一个或数组多个判断是否有某个操作权限
    
    
#### StarsRole

    1、创建一个角色
    createRole( string $roleName, string $roleDisplayName  )

    2、获取一个角色实例
    info( $filter ) 可以传递id，名称
    
    3、绑定用户
    bindUsers( array $UserIds  )
    
    4、解绑指定用户
    deleteUsers( array $userIds );
    
    5、绑定权限
    bindPermissions(array $permissionIds )
    
    6、删除权限
    deletePermissions( array $permissionsIds );

#### StarsPermission

    1、创建一个权限
    createPermission($permissionName, $displayName )
   
    2、获取一个权限实例
    info( $filter ) 可以传递id，名称
    
    3、授权给指定角色
    appendToRole( int $roleId )

#### 调用实例

    $user = new StarsUser();
    $role = new StarsRole();
    $permission = new StarsPermission();

    //$permission = $permission->createPermission( 'zhuijia' ,'紧急追加权限' );
    //$permission->appendToRole( 5 );
    // $role->createRole('editor' ,'系统编辑');
    // $user->createUser( 'mengdeliang' , '123456' ,1 );

    $roleInfo = $role->info(5);
    //$roleInfo->deletePermissions([66,77,88,99]);
    //$roleInfo->bindPermissions([66,77,88,99]);
    //$roleInfo->bindUsers([7,8,9]);
    //$roleInfo->deleteUsers( [7,8,9] );
    $userInfo = $user->info( 1);

     //$userInfo->bindRoles([123,123,123123123]);
    //$userInfo->deleteRoles([44]);
    //$userInfo->clearRoles();
    //$x= $userInfo ->hasRole( 'nnn');
    //$x= $userInfo ->hasRole( ['nsssnn','11','qq']);
    //dd( $x);
    // dd($userInfo ->can( 'zhuijia'));
    dd($userInfo ->can( ['nnn']));
