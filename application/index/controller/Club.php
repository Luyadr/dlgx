<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\MemberModel;
use app\index\model\ClubModel;
use app\index\model\ClubJoinModel;
use app\index\model\ClubApplyModel;

class Club extends Controller
{
    protected $beforeActionList = [
        'checkMember' => ['except' => 'index,join']
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
        $clubId = input('param.clubId');
        $clubModel = new ClubModel();
        $club = $clubModel->getInfoById($clubId);
        if($club['club_owner_id'] == session('memberId')) {
            $status = 1;
        } else {
            $status = 0;
        }

        $clubJoinModel = new ClubJoinModel();
        $self = $clubJoinModel->getListByWhere(array('club_id' => $clubId, 'member_id' => session('memberId')));
        $applyStatus = 0;
        if( ! empty($self)) {
            if($self[0]['verify_status'] == 1) {
                $applyStatus = 1;
            } elseif($self[0]['verify_status'] == 2) {
                $applyStatus = 2;
            }
        }
        $memberModel = new MemberModel();
        $member = $memberModel->getInfoById($club['club_owner_id']);
        $memberList = $clubJoinModel->getJoinMember(array('club_id' => $clubId, 'verify_status' => 2));

        $this->assign([
            'club' => $club,
            'status' => $status,
            'applyStatus' => $applyStatus,
            'member' => $member,
            'memberList' => $memberList
        ]);

        return $this->fetch('/club');
    }

    public function clubJoined()
    {
        $clubJoinModel = new ClubJoinModel();
        $clubList = $clubJoinModel->getJoinClub(array('member_id' => session('memberId'), 'verify_status' => 2));
        $this->assign([
            'clubList' => $clubList
        ]);
        return $this->fetch('/club-joined');
    }

    public function clubCreated()
    {
        $clubModel = new ClubModel();
        $clubList = $clubModel->getListByWhere(array('club_owner_id' => session('memberId')));
        $this->assign([
            'clubList' => $clubList
        ]);
        return $this->fetch('/club-created');
    }

    public function select()
    {
        $memberModel = new MemberModel();
        $member = $memberModel->getInfoById(session('memberId'));
        $where = [];
        $where['club_status'] = 1;
        $where['club_school'] = $member['member_school'];
        $clubModel = new ClubModel();
        $clubList = $clubModel->getListByWhere($where);
        $this->assign([
            'clubList' => $clubList
        ]);

        return $this->fetch('/club-select');
    }

    public function create()
    {
        if(request()->isAjax()) {
            $clubModel = new ClubModel();
            $club = $clubModel->getListByWhere(array('club_owner_id' => session('memberId')));
            if(!empty($club)) {
                return ['code' => -1, 'msg' => '您已创建过社团，可别分身乏术哦！'];
            } else {
                $clubApplyModel = new ClubApplyModel();
                $clubApplying = $clubApplyModel->getListByWhere(array('club_owner_id' => session('memberId'), 'verify_status' => 1));
                if(!empty($clubApplying)) {
                    return json(['code' => -2, 'msg' => '您有社团申请正在处理！']);
                } else {
                    $memberModel = new MemberModel();
                    $member = $memberModel->getInfoById(session('memberId'));
                    $params = input('param.');
                    $params = parseParams($params['data']);
                    if($params['club_level'] == '兴趣社团') {
                        $params['club_level'] = 1;
                    } elseif($params['club_level'] == '院级组织') {
                        $params['club_level'] = 2;
                    } elseif($params['club_level'] == '校级组织') {
                        $params['club_level'] = 3;
                    }
                    $params['club_intro'] = '（暂无简介）';
                    $params['club_school'] = $member['member_school'];
                    $params['club_owner_id'] = session('memberId');
                    $params['apply_time'] = time();
                    $flag = $clubApplyModel->insert($params, 'ClubValidate');
                    if($flag['code'] == 1) {
                        $return['code'] = -2;
                        $return['msg'] = '您的社团申请已提交！';
                    } else {
                        $return['msg'] = $flag['msg'];
                    }
                    return json($return);
                }
            }
        }
        return $this->fetch('/club-create');
    }

    public function join()
    {
        $memberModel = new MemberModel();
        $member = $memberModel->getInfoById(session('memberId'));
        if(empty($member['member_tel'])) {
            $return['flag'] = -1;
        } else {
            $clubId = input('param.id');
            $clubJoinModel = new ClubJoinModel();
            $clubJoinList = $clubJoinModel->getListByWhere(array('club_id' => $clubId, 'member_id' => session('memberId')));
            if(empty($clubJoinList) || ($clubJoinList[0]['verify_status'] == 3)) {
                $params = [];
                $params['club_id'] = $clubId;
                $params['member_id'] = session('memberId');
                $params['apply_time'] = time();
                $return['flag'] = db('club_join')->insertGetId($params);
            } else {
                $return['flag'] = 0;
            }
        }

        return json($return);
    }

    public function cancel()
    {
        $clubId = input('param.id');
        $clubJoinModel = new ClubJoinModel();
        $clubJoinList = $clubJoinModel->getListByWhere(array('club_id' => $clubId, 'member_id' => session('memberId')));
        $params = [];
        $params['id'] = $clubJoinList[0]['id'];
        $params['verify_status'] = 0;
        $flag = $clubJoinModel->edit($params, '');

        return json($flag);
    }
}
