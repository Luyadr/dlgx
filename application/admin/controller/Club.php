<?php
namespace app\admin\controller;

use app\admin\model\ClubModel;
use app\admin\model\RoleModel;
use app\admin\model\Club_applyModel;

class Club extends Base
{
    //用户列表
    public function index()
    {
        if(request()->isAjax()){

            $param = input('param.');

            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            $where = [];
            if (isset($param['searchText']) && !empty($param['searchText'])) {
                $where['club_name'] = ['like', '%' . $param['searchText'] . '%'];
            }
            $club = new ClubModel();
            $selectResult = $club->getClubsByWhere($where, $offset, $limit);

            $status = config('verify_status');
            $club_level= config('club_level');
            foreach($selectResult as $key=>$vo){

                $selectResult[$key]['apply_time'] = date('Y-m-d H:i:s', $vo['apply_time']);
                $selectResult[$key]['verify_status'] = $status[$vo['verify_status']];
                $selectResult[$key]['club_level'] = $club_level[$vo['club_level']];

                $operate = [
                    '审核' => url('club/apply', ['id' => $vo['id']]),
                    '删除' => "javascript:del('".$vo['id']."')"
                ];

                $selectResult[$key]['operate'] = showOperate($operate);

            }

            $return['total'] = $club->getAllClubs($where);  //总数据
            $return['rows'] = $selectResult;

            return json($return);
        }

        return $this->fetch();
    }


    //审核社团
    public function apply()
    {
        $club = new ClubModel();

        if(request()->isPost()){

            $param = input('post.');
            $param = parseParams($param['data']);

            $flag = $club->editClub($param,'clubValidate');
            if($flag&&$param['verify_status'] =='2'){
                $club_apply = new Club_applyModel(); //给club表增加数据
                unset($param['id']);unset($param['club_owner_idcard']);unset($param['apply_time']);unset($param['verify_status']);unset($param['verify_idea']);
                $param['club_create_time'] = time();
                $param['club_status'] = 1;
                $flag = $club_apply->insertClub_apply($param,'clubValidate');
            }
            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

        $id = input('param.id');
        $this->assign([
            'club' => $club->getOneClub($id),
            'verify_status' => config('club_status')
        ]);
        return $this->fetch();
    }

    //删除角色
    public function del()
    {
        $id = input('param.id');

        $club = new ClubModel();
        $flag = $club->delClub($id);
        return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
    }
}