<?php
// +----------------------------------------------------------------------
// | snake
// +----------------------------------------------------------------------
// | Copyright (c) 2016~2022 http://baiyf.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: NickBai <1902822973@qq.com>
// +----------------------------------------------------------------------
namespace app\admin\controller;

use app\admin\model\NodeModel;
use app\admin\model\RoleModel;
use app\admin\model\UserType;

class Role extends Base
{
    //角色列表
    public function index()
    {
        if(request()->isAjax()){

            $param = input('param.');

            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            $where = [];
            if (isset($param['searchText']) && !empty($param['searchText'])) {
                $where['role_name'] = ['like', '%' . $param['searchText'] . '%'];
            }
            $user = new RoleModel();
            $selectResult = $user->getRoleByWhere($where, $offset, $limit);
            foreach($selectResult as $key=>$vo){

                if(1 == $vo['id']){
                    $selectResult[$key]['operate'] = '';
                    continue;
                }

                $operate = [
                    '编辑' => url('role/edit', ['id' => $vo['id']]),
                    '删除' => "javascript:del('".$vo['id']."')",
                    '分配权限' => "javascript:givepermission('".$vo['id']."')"
                ];
                $selectResult[$key]['operate'] = showOperate($operate);

            }

            $return['total'] = $user->getAllRole($where);  //总数据
            $return['rows'] = $selectResult;

            return json($return);
        }

        return $this->fetch();
    }

    //添加角色
    public function add()
    {
        if(request()->isPost()){

            $param = input('param.');
            $param = parseParams($param['data']);

            $role = new RoleModel();
            $flag = $role->insertRole($param,'RoleValidate');

            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

        return $this->fetch();
    }

    //编辑角色
    public function edit()
    {
        $role = new RoleModel();

        if(request()->isPost()){

            $param = input('post.');
            $param = parseParams($param['data']);

            $flag = $role->editRole($param,'RoleValidate');

            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

        $id = input('param.id');
        $this->assign([
            'role' => $role->getRoleInfo($id)
        ]);
        return $this->fetch();
    }

    //删除角色
    public function del()
    {
        $id = input('param.id');

        $role = new RoleModel();
        $flag = $role->delRole($id);
        return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
    }

    //分配权限
    public function givepermission()
    {
        $param = input('param.');
        $node = new NodeModel();
        //获取现在的权限
        if('get' == $param['type']){

            $nodeStr = $node->getNodeInfo($param['id']);
            return json(['code' => 1, 'data' => $nodeStr, 'msg' => 'success']);
        }
        //分配新权限
        if('give' == $param['type']){

            $doparam = [
                'id' => $param['id'],
                'permission_node' => $param['permission_node']
            ];
            $user = new UserType();
            $flag = $user->editAccess($doparam);
            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }
    }
}