<?php
namespace app\admin\model;

class RoleModel extends BaseModel
{
    protected  $table = 'dlgx_role';
    /**
     * 分配权限
     * @param $param
     */
    public function editAccess($param)
    {
        try{
            $this->save($param, ['id' => $param['id']]);
            return ['code' => 1, 'data' => '', 'msg' => '分配权限成功'];
        }catch( PDOException $e){
            return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
        }
    }
    /**
     * 获取角色信息
     * @param $id
     */
    public function getRoleInfo($id){
        $result = db('role')->where('id', $id)->find();
        if(empty($result['permission_node'])){
            $where = '';
        }else{
            $where = 'id in('.$result['permission_node'].')';
        }
        $res = db('node')->field('controller_name,action_name')->where($where)->select();
        foreach($res as $key=>$vo){
            if('#' != $vo['action_name']){
                $result['action'][] = $vo['controller_name'] . '/' . $vo['action_name'];
            }
        }
        return $result;
    }
	
	public function insertRole($param, $validateName)
    {
        try{
            $result =  $this->validate($validateName)->save($param);

            if(FALSE === $result){
                // 验证失败 输出错误信息
                return ['code' => -1, 'data' => '', 'msg' => $this->getError()];
            }else{
                return ['code' => 1, 'data' => '', 'msg' => '添加成功'];
            }
        }catch( PDOException $e){
            return ['code' => -2, 'data' => '', 'msg' => $e->getMessage()];
        }
    }
	
	/**
     * 根据条件获取用户列表
     * @param $where
     * @param $offset
     * @param $limit
     */
    public function getRoleByWhere($where, $offset, $limit)
    {
        return $this->field('dlgx_role.*,role_name')
            ->where($where)->limit($offset, $limit)->order('id desc')->select();
    }
	
	/**
     * 编辑
     * @param $param
     * @param $validateName
     * @return array
     */
    public function editRole($param, $validateName)
    {
        try{
            $result =  $this->validate($validateName)->save($param, ['id' => $param['id']]);
            if(FALSE === $result){
                // 验证失败 输出错误信息
                return ['code' => -1, 'data' => '', 'msg' => $this->getError()];
            }else{
                return ['code' => 1, 'data' => '', 'msg' => '编辑成功'];
            }
        }catch( PDOException $e){
            return ['code' => -2, 'data' => '', 'msg' => $e->getMessage()];
        }
    }
    /**
     * 删除
     * @param $id
     * @return array
     */
    public function delRole($id)
    {
        try{
            $this->where('id', $id)->delete();
            return ['code' => 1, 'data' => '', 'msg' => '删除成功'];
        }catch( PDOException $e){
            return ['code' => -2, 'data' => '', 'msg' => $e->getMessage()];
        }
    }

	/**
     * 根据条件获取所有数据
     * @param $where
     * @return array
     */
    public function getAllRole($where)
    {
        return $this->where($where);
    }
	public function getRole()
   {
	     return $this->select();
   }
}