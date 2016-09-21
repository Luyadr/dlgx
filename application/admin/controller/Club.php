<?php
namespace app\admin\controller;

use app\admin\model\ClubModel;
use app\index\model\ClubApplyModel;
use app\index\model\MemberModel;

class Club extends Base
{
    public function index()
    {
        if (request()->isAjax()) {

            $param = input('param.');

            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            $where = [];
            if (isset($param['searchText']) && !empty($param['searchText'])) {
                $where['club_name'] = ['like', '%' . $param['searchText'] . '%'];
            }
            $club = new ClubModel();
            $selectResult = $club->getListByWhere($where, $offset, $limit);

            $status = config('club_status');
            $club_level = config('club_level');
            foreach ($selectResult as $key => $vo) {
                $member = new MemberModel();
                $info = $member->getInfoById($vo['club_owner_id']);//查询社团团长名字
                $selectResult[$key]['club_owner_id'] = $info['member_name'];
                $selectResult[$key]['club_status'] = $status[$vo['club_status']];
                $selectResult[$key]['club_level'] = $club_level[$vo['club_level']];

                $operate = [
                    '编辑' => url('club/edit', ['id' => $vo['id']])
                ];

                $selectResult[$key]['operate'] = showOperate($operate);

            }

            $return['total'] = $club->getCounts($where);  //总数据
            $return['rows'] = $selectResult;

            return json($return);
        }

        return $this->fetch();
    }

    //编辑审核社团
    public function editApply()
    {
        $club = new ClubApplyModel();

        if (request()->isPost()) {

            $param = input('post.');
            $param = parseParams($param['data']);
            $flag = $club->edit($param, 'clubValidate');
            if ($param['verify_status'] == 2) {
                $club = new ClubModel();
                unset($param['verify_status']);
                unset($param['id']);
                unset($param['verify_idea']);
                $param['club_status'] = 1;
                $param['club_create_time'] = time();
                $club->insert($param, 'clubValidate');
            }
            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

        $id = input('param.id');
        $this->assign([
            'club' => $club->getInfoById($id),
            'verify_status' => config('verify_status')
        ]);
        return $this->fetch('club/edit_apply');
    }
    //编辑社团状态
    public function edit()
    {
        $club = new ClubModel();

        if (request()->isPost()) {

            $param = input('post.');
            $param = parseParams($param['data']);
            $flag = $club->edit($param, 'clubValidate');
            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

        $id = input('param.id');
        $this->assign([
            'club' => $club->getInfoById($id),
            'club_status' => config('club_status')
        ]);
        return $this->fetch();
    }

    //审核社团列表
    public function apply()
    {
        if (request()->isAjax()) {

            $param = input('param.');

            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            $where = [];
            if (isset($param['searchText']) && !empty($param['searchText'])) {
                $where['club_name'] = ['like', '%' . $param['searchText'] . '%'];
            }
            $club = new ClubApplyModel();
            $selectResult = $club->getListByWhere($where, $offset, $limit);
            $status = config('apply_status');
            $club_level = config('club_level');
            foreach ($selectResult as $key => $vo) {
                $member = new MemberModel();
                $info = $member->getInfoById($vo['club_owner_id']);//查询社团团长名字
                $selectResult[$key]['club_owner_id'] = $info['member_name'];
                $selectResult[$key]['club_level'] = $club_level[$vo['club_level']];
                if ($selectResult[$key]['verify_status'] == 1) {
                    $operate = [
                        '审核' => url('club/editApply', ['id' => $vo['id']]),
                    ];
                    $selectResult[$key]['operate'] = showOperate($operate);
                }
                $selectResult[$key]['verify_status'] = $status[$vo['verify_status']];

            }

            $return['total'] = $club->getCounts($where);  //总数据
            $return['rows'] = $selectResult;

            return json($return);
        }

        return $this->fetch();
    }

    //删除角色
    public function del()
    {
        $id = input('param.id');

        $club = new ClubModel();
        $flag = $club->del($id);
        return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
    }
}