<?php
namespace app\admin\controller;
use app\admin\model\ActivityModel;
use app\admin\model\RoleModel;
use Qiniu\Auth;
class Activity extends Base
{

    //活动列表
    public function index()
    {
        if(request()->isAjax()){

            $param = input('param.');

            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            $where = [];
            if (isset($param['searchText']) && !empty($param['searchText'])) {
                $where['act_name'] = ['like', '%' . $param['searchText'] . '%'];
            }
            $activity = new ActivityModel();
            $selectResult = $activity->getactivitysByWhere($where, $offset, $limit);

            foreach($selectResult as $key=>$vo){
                $selectResult[$key]['act_create_time'] = date('Y-m-d H:i:s', $vo['act_create_time']);
                $selectResult[$key]['act_release_time'] = date('Y-m-d H:i:s', $vo['act_release_time']);
                $selectResult[$key]['act_start_time'] = date('Y-m-d H:i:s', $vo['act_start_time']);
                $selectResult[$key]['act_end_time'] = date('Y-m-d H:i:s', $vo['act_end_time']);
                if($vo['act_from_id'] == 0){
                    $selectResult[$key]['act_from_id'] = '官方';
                }
                $operate = [
                    '编辑' => url('activity/edit', ['id' => $vo['id']]),
                    '删除' => "javascript:del('".$vo['id']."')"
                ];

                $selectResult[$key]['operate'] = showOperate($operate);

            }

            $return['total'] = $activity->getAllactivitys($where);  //总数据
            $return['rows'] = $selectResult;

            return json($return);
        }

        return $this->fetch();
    }
    //添加活动
    public function add()
    {
        if(request()->isPost()){
            $param = input('param.');
            $param = parseParams($param['data']);
            $param['act_start_time'] = strtotime($param['act_start_time']);
            $param['act_end_time'] = strtotime($param['act_end_time']);
            $param['act_release_time'] = strtotime($param['act_release_time']);
            $param['act_create_time'] = time();
            $activity = new activityModel();
            $flag = $activity->insertactivity($param,'ActivityValidate');

            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

        $role = new RoleModel();
        $this->assign([
            'role' => $role->getRole(),
        ]);

        return $this->fetch();
    }

    //编辑活动
    public function edit()
    {
        $activity = new activityModel();

        if(request()->isPost()){

            $param = input('post.');
            $param = parseParams($param['data']);
            $param['act_start_time'] = strtotime($param['act_start_time']);
            $param['act_end_time'] = strtotime($param['act_end_time']);
            $param['act_release_time'] = strtotime($param['act_release_time']);
            $param['act_create_time'] = time();
            $flag = $activity->editactivity($param,'ActivityValidate');

            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

        $id = input('param.id');
        $info =  $activity->getOneactivity($id);
        $info['act_start_time'] = date('Y-m-d H:i:s', $info['act_start_time']);
        $info['act_release_time'] = date('Y-m-d H:i:s', $info['act_release_time']);
        $info['act_end_time'] = date('Y-m-d H:i:s', $info['act_end_time']);
        $info['act_create_time'] = date('Y-m-d H:i:s', $info['act_create_time']);
        $this->assign([
            'activity' => $info
        ]);
        return $this->fetch();
    }

    //删除活动
    public function del()
    {
        $id = input('param.id');

        $role = new activityModel();
        $flag = $role->delactivity($id);
        return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
    }
}