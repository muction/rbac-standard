<?php
namespace Rbac\Standard\Entity;
use Illuminate\Database\Eloquent\Model;

/**
 * 组织架构
 * Class RbacOrganize
 * @package Rbac\Standard\Entity
 */
class RbacOrganize extends Model
{
    protected $fillable = ['name' ,'display_name' ,'parent_id' ,'level'];

    /**
     * 新增
     * @param $name
     * @param $displayName
     * @return mixed
     */
    public function storage( $name, $displayName , $parentId, $level ){
        return self::create([
            'name'=>$name ,
            'display_name'=>$displayName,
            'parent_id'=>$parentId,
            'level'=>$level
        ]);
    }

    /**
     * 更新
     * @param $id
     * @param array $update
     * @return mixed
     */
    public function modify( $id, array $update ){

        $info = $this->info($id);
        if(!$info){
            return false;
        }
        /*
        $levelChange = $update['level']-$info['level'];
        $valueIds = self::value('id');
        $valueIds = $valueIds ? $valueIds->toArray() : [];

        $allChildrenNodes = self::findAllChildrenNodes( $valueIds );
         */
    }

    /**
     * move menu level
     * @param array $menuIds
     * @param int $levelChange
     * @return mixed
     */
    public function levelChange(array $ids , $levelChange ){
        return self::whereIn('id', $ids)->increment('level', $levelChange);
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


    public static function findAllChildrenNodes($arrCat, $parent_id = 0, $level = 0)
    {
        static  $arrTree = array();
        if( empty($arrCat)) return FALSE;
        $level++;
        foreach($arrCat as $key => $value)
        {
            if($value['parent_id' ] == $parent_id)
            {
                $value[ 'level'] = $level;
                $arrTree[] = $value;
                unset($arrCat[$key]); //注销当前节点数据，减少已无用的遍历
                self::findAllChildrenNodes($arrCat, $value[ 'id'], $level);
            }
        }

        return $arrTree;
    }
}
