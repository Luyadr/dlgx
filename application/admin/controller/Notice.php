<?php
namespace app\admin\controller;

use app\admin\model\NoticeModel;

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
            $selectResult = $notice->getListByWhere($where, $offset, $limit);


            foreach($selectResult as $key=>$vo){

                if($vo['notice_from_id'] == 0){
                    $selectResult[$key]['notice_from_id'] = '官方';
                }
                if($vo['notice_release_time'] == 0){
                    $selectResult[$key]['notice_release_time'] = '未发布';
                }else{
                    $selectResult[$key]['notice_release_time'] =  date('Y-m-d H:i:s', $vo['notice_release_time']);
                }

                $operate = [
                    '编辑' => url('notice/edit', ['id' => $vo['id']]),
                    '删除' => "javascript:del('".$vo['id']."')"
                ];

                $selectResult[$key]['operate'] = showOperate($operate);

            }

            $return['total'] = $notice->getCounts($where);  //总数据
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
            $param['notice_from_id'] = 0;
            if($param['notice_status'] == 1) {
                $param['notice_release_time'] = time();
            } elseif($param['notice_tatus'] == 2) {
                $param['notice_release_time'] = 0;
            }
            unset($param['notice_status']);
            $notice = new NoticeModel();
            $flag = $notice->insert($param,'NoticeValidate');
           
            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }
        $this->assign([
            'status' => config('notice_status')
        ]);

        return $this->fetch();
    }

    //编辑广告
    public function edit()
    {
        $notice = new NoticeModel();

        if(request()->isPost()){

            $param = input('post.');
            $param = parseParams($param['data']);
            if($param['notice_status'] == 1) {
                $param['notice_release_time'] = time();
            } elseif($param['notice_status'] == 2) {
                $param['notice_release_time'] = 0;
            }
            unset($param['notice_status']);
            $flag = $notice->edit($param,'NoticeValidate');

            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

        $id = input('param.id');
        $info =  $notice->getInfoById($id);
        if($info['notice_release_time'] == 0) {
            $info['notice_status'] = 2;
        } else {
            $info['notice_status'] = 1;
        }
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
        $flag = $role->del($id);
        return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
    }
}