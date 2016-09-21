<?php
namespace app\admin\controller;

use app\admin\model\ActivityModel;

class Activity extends Base
{
    //活动列表
    public function index()
    {
        if (request()->isAjax()) {
            $param = input('param.');
            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;
            $where = [];
            if (isset($param['searchText']) && !empty($param['searchText'])) {
                $where['act_name'] = ['like', '%' . $param['searchText'] . '%'];
            }
            $activity = new ActivityModel();
            $selectResult = $activity->getListByWhere($where, $offset, $limit);
            foreach ($selectResult as $key => $vo) {
                $selectResult[$key]['act_name'] = mb_substr($vo['act_name'], 0, 16);
                $selectResult[$key]['act_intro'] = mb_substr($vo['act_intro'], 0, 32);
                $selectResult[$key]['act_create_time'] = date('Y-m-d H:i:s', $vo['act_create_time']);
                $selectResult[$key]['act_start_time'] = date('Y-m-d H:i:s', $vo['act_start_time']);
                $selectResult[$key]['act_end_time'] = date('Y-m-d H:i:s', $vo['act_end_time']);
                $selectResult[$key]['act_money'] =  $vo['act_money'].'元';
                if ($vo['act_release_time'] == 0) {
                    $selectResult[$key]['act_release_time'] = '未发布';
                } else {
                    $selectResult[$key]['act_release_time'] = date('Y-m-d H:i:s', $vo['act_release_time']);
                }
                $operate = [
                    '编辑' => url('activity/edit', ['id' => $vo['id']]),
                    '删除' => "javascript:del('" . $vo['id'] . "')"
                ];
                $selectResult[$key]['operate'] = showOperate($operate);
            }
            $return['total'] = $activity->getCounts($where);
            $return['rows'] = $selectResult;
            return json($return);
        }
        return $this->fetch();
    }
    //添加活动
    public function add()
    {
        if (request()->isPost()) {
            $param = input('param.');
            $param = parseParams($param['data']);
            $param['act_start_time'] = strtotime($param['act_start_time']);
            $param['act_end_time'] = strtotime($param['act_end_time']);
            $param['act_create_time'] = time();
            if ($param['activity_status'] == 1) {
                $param['act_release_time'] = time();
            } elseif ($param['activity_status'] == 2) {
                $param['act_release_time'] = 0;
            }
            unset($param['activity_status']);
            $activity = new activityModel();
            $flag = $activity->insert($param, 'ActivityValidate');
            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }
        return $this->fetch();
    }
    //编辑活动
    public function edit()
    {
        $activity = new activityModel();
        if (request()->isPost()) {
            $param = input('post.');
            $param = parseParams($param['data']);
            $param['act_start_time'] = strtotime($param['act_start_time']);
            $param['act_end_time'] = strtotime($param['act_end_time']);
            $param['act_create_time'] = time();
            if ($param['activity_status'] == 1) {
                $param['act_release_time'] = time();
            } elseif ($param['activity_status'] == 2) {
                $param['act_release_time'] = 0;
            }
            unset($param['activity_status']);
            $flag = $activity->edit($param, 'ActivityValidate');
            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }
        $id = input('param.id');
        $info = $activity->getInfoById($id);
        $info['act_start_time'] = date('Y-m-d H:i:s', $info['act_start_time']);
        $info['act_end_time'] = date('Y-m-d H:i:s', $info['act_end_time']);
        $info['act_create_time'] = date('Y-m-d H:i:s', $info['act_create_time']);
        if ($info['act_release_time'] == 0) {
            $info['activity_status'] = 2;
        } else {
            $info['activity_status'] = 1;
        }
        $this->assign([
            'activity' => $info
        ]);
        return $this->fetch();
    }
    //删除活动
    public function del()
    {
        $id = input('param.id');
        $activity = new activityModel();
        $flag = $activity->del($id);
        return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
    }
}