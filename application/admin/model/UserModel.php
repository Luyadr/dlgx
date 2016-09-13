<?php
namespace app\admin\model;

class UserModel extends BaseModel
{
    protected $table = 'dlgx_user';

    /**
     * 根据条件获取用户列表
     * @param $where
     * @param $offset
     * @param $limit
     */
    public function getUsersByWhere($where, $offset, $limit)
    {
        return $this->field('dlgx_user.*,role_name')
            ->join('dlgx_role', 'dlgx_user.father_node_id = dlgx_role.id')
            ->where($where)->limit($offset, $limit)->order('id desc')->select();
    }
}