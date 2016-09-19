<?php
namespace app\admin\controller;

use app\admin\model\NoticeModel;
use app\admin\model\RoleModel;

class Notice extends Base
{
    //公告列表
    public function index()
    {
        if(request()->isAjax()){

            $param = input('param.');

            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            $where = [];
            if (isset($param['searchText']) && !empty($param['searchText'])) {
                $where['notice_title'] = ['like', '%' . $param['searchText'] . '%'];
            }
            $notice = new NoticeModel();
            $selectResult = $notice->getNoticesByWhere($where, $offset, $limit);


            foreach($selectResult as $key=>$vo){

                $selectResult[$key]['notice_release_time'] = date('Y-m-d H:i:s', $vo['notice_release_time']);
                if($vo['notice_from_id'] == 0){
                    $selectResult[$key]['notice_from_id'] = '官方';
                }

                $operate = [
                    '编辑' => url('notice/edit', ['id' => $vo['id']]),
                    '删除' => "javascript:del('".$vo['id']."')"
                ];

                $selectResult[$key]['operate'] = showOperate($operate);

            }

            $return['total'] = $notice->getAllNotices($where);  //总数据
            $return['rows'] = $selectResult;

            return json($return);
        }

        return $this->fetch();
    }

    //添加公告
    public function add()
    {
        if(request()->isPost()){

            $param = input('param.');
          
            $param = parseParams($param['data']);
            $param['notice_release_time'] = strtotime($param['notice_release_time']);
            $notice = new NoticeModel();
            $flag = $notice->insertNotice($param,'NoticeValidate');
           
            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

        $role = new RoleModel();
        $this->assign([
            'role' => $role->getRole(),
            'status' => config('notice_status')
        ]);

        return $this->fetch();
    }

    //编辑角色
    public function edit()
    {
        $notice = new NoticeModel();

        if(request()->isPost()){

            $param = input('post.');
            $param = parseParams($param['data']);
            $param['notice_release_time'] = strtotime($param['notice_release_time']);
            $flag = $notice->editNotice($param,'NoticeValidate');

            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

        $id = input('param.id');
        $info =  $notice->getOneNotice($id);
        $info['notice_release_time'] = date('Y-m-d H:i:s', $info['notice_release_time']);
        $this->assign([
            'notice' => $info
        ]);
        return $this->fetch();
    }

    //删除角色
    public function del()
    {
        $id = input('param.id');

        $role = new NoticeModel();
        $flag = $role->delNotice($id);
        return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
    }
}