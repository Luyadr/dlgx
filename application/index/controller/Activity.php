<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\MemberModel;
use app\index\model\ActivityModel;
use app\index\model\ActJoinModel;

class Activity extends Controller
{
    protected $beforeActionList = [
        'checkMember' => ['only' => 'actlist,cancel']
    ];

    public function checkMember()
    {
        $memberModel = new MemberModel();
        $member = $memberModel->getInfoById(session('memberId'));
        if(empty($member['member_tel'])) {
            $this->redirect('member/edit');
        }
    }

    public function index()
    {
        $actId = input('param.act_id');
        $actJoinModel = new ActJoinModel();
        $memberCounts = $actJoinModel->getCounts(array('act_id' => $actId));
        $actJoinList = $actJoinModel->getJoinMember(array('act_id' => $actId), 0, 10);
        $this->assign([
            'memberCounts' => $memberCounts,
            'actJoinList' => $actJoinList
        ]);

        $activityModel = new ActivityModel();
        $activityInfo = $activityModel->getInfoById($actId);
        $stime = $activityInfo['act_start_time'];
        $etime = $activityInfo['act_end_time'];
        if(time() < $stime) {
            $activityInfo['act_status'] = 1;
        } elseif(time() > $etime) {
            $activityInfo['act_status'] = 3;
        } else {
            $activityInfo['act_status'] = 2;
        }
        $this->assign([
            'activityInfo' => $activityInfo
        ]);
        $activityInfo['act_name'] = mb_substr($activityInfo['act_name'], 0, 16);
        $activityInfo['act_start_time'] = date('m-d H:i', $stime);
        $activityInfo['act_end_time'] = date('m-d H:i', $etime);
        $days = floor( ( time() - $activityInfo['act_release_time'] ) / 86400 );
        if(0 == $days) {
            $activityInfo['act_days'] = '今天';
        } else {
            $activityInfo['act_days'] = $days.'天前';
        }

        return $this->fetch('/activity');
    }

    public function actList()
    {
        $actJoinModel = new ActJoinModel();
        $activityList = $actJoinModel->getJoinAct(array('member_id' => session('memberId')));
        foreach($activityList as $key=>$vo){
            $stime = $activityList[$key]['act_start_time'];
            $etime = $activityList[$key]['act_end_time'];
            if(time() < $stime) {
                $activityList[$key]['act_status'] = 1;
            } elseif(time() > $etime) {
                $activityList[$key]['act_status'] = 3;
            } else {
                $activityList[$key]['act_status'] = 2;
            }
            $activityList[$key]['act_name'] = mb_substr($vo['act_name'], 0, 16);
            $activityList[$key]['act_start_time'] = date('m-d H:i', $stime);
            $activityList[$key]['act_end_time'] = date('m-d H:i', $etime);
            $days = floor((time() - $activityList[$key]['act_release_time']) / 86400);
            if($days == 0) {
                $activityList[$key]['act_days'] = '今天';
            } else {
                $activityList[$key]['act_days'] = $days.'天前';
            }
        }
        $this->assign([
            'activityList' => $activityList
        ]);

        return $this->fetch('/activity-list');
    }

    public function join()
    {
        $memberModel = new MemberModel();
        $member = $memberModel->getInfoById(session('memberId'));
        if(empty($member['member_tel'])) {
            $return['flag'] = -1;
        } else {
            $actId = input('param.id');
            $actJoinModel = new ActJoinModel();
            $counts = $actJoinModel->getCounts(array('act_id' => $actId, 'member_id' => session('memberId')));
            if(empty($counts)) {
                $params = [];
                $params['act_id'] = $actId;
                $params['member_id'] = session('memberId');
                $params['join_time'] = time();
                $return['flag'] = db('act_join')->insertGetId($params);
            } else {
                $return['flag'] = 0;
            }
        }

        return json($return);
    }

    public function cancel()
    {
        $actId = input('param.id');
        $memberId = session('memberId');
        $return['flag'] = db('act_join')->where(array('act_id' => $actId, 'member_id' => $memberId))->delete();

        return json($return);
    }
}
