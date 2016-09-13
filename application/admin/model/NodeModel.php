<?php
namespace app\admin\model;

class NodeModel extends BaseModel
{
    protected $table = "dlgx_node";
    /**
     * 根据节点数据获取对应的菜单
     * @param $nodeStr
     * @return array
     */
    public function getMenu($nodeStr = '')
    {
        //超级管理员没有节点数据
        $where = empty($nodeStr) ? 'is_menu = 2' : 'is_menu = 2 and id in('.$nodeStr.')';

        $result = db('node')->field('id,node_name,controller_name,action_name,father_node_id,style')
            ->where($where)->select();

        $menu = prepareMenu($result);

        return $menu;
    }


}
