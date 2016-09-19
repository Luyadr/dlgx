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

   public function getAllInfo()
   {
	     return $this->select();
   }
    /**
     * 获取节点数据
     */
    public function getNodeInfo($id)
    {
        $result = $this->field('id,node_name,father_node_id')->select();
        $str = "";

        $role = new UserType();
        $rule = $role->getRuleById($id);

        if(!empty($rule)){
            $rule = explode(',', $rule);
        }
        foreach($result as $key=>$vo){
            $str .= '{ "id": "' . $vo['id'] . '", "pId":"' . $vo['father_node_id'] . '", "name":"' . $vo['node_name'].'"';

            if(!empty($rule) && in_array($vo['id'], $rule)){
                $str .= ' ,"checked":1';
            }

            $str .= '},';

        }

        return "[" . substr($str, 0, -1) . "]";
    }

}
