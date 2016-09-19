<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\ClubModel;
use app\index\model\ClubJoinModel;

class Check extends Controller
{
    public function index()
    {
        $clubModel = new ClubModel();
        $clubList = $clubModel->getListByWhere(array('club_owner_id' => session('memberId')));
        $clubId = $clubList[0]['id'];
        $clubJoinModel = new ClubJoinModel();
        $clubJoinList = $clubJoinModel->getListByWhere(array('club_id' => $clubId, 'verify_status' => 1));
        $this->assign([
            'clubJoinList' => $clubJoinList
        ]);
        return $this->fetch('/check');
    }

    public function accept()
    {
        $checkId = input('param.id');
        $clubJoinModel = new ClubJoinModel();

        $params = [];
        $params['id'] = $checkId;
        $params['verify_status'] = 2;
        $flag = $clubJoinModel->edit($params, '');

        return json($flag);
    }

    public function refuse()
    {
        $checkId = input('param.id');
        $clubJoinModel = new ClubJoinModel();

        $params = [];
        $params['id'] = $checkId;
        $params['verify_status'] = 3;
        $flag = $clubJoinModel->edit($params, '');

        return json($flag);
    }
}
