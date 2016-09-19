<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\MemberModel;
use app\index\model\ClubModel;

class Member extends Controller
{
    public function index()
    {
        $clubModel = new ClubModel();
        $clubCounts = $clubModel->getCounts(array('club_owner_id' => session('memberId')));
        $this->assign([
            'memberIcon' => session('memberIcon'),
            'memberName' => session('memberName'),
            'clubCounts' => $clubCounts
        ]);

        return $this->fetch('/my');
    }

    public function edit()
    {
        if(request()->isAjax()) {
            $params = input('param.');
            $params = parseParams($params['data']);
            $memberModel = new MemberModel();
            $flag = $memberModel->edit($params, 'MemberValidate');
            return json(['code' => $flag['code'], 'msg' => $flag['msg']]);
        } else {
            if(!empty(input('param.memberForm'))) {
                $memberInfo = parseParams(input('param.memberForm'));
                $memberInfo['member_school'] = input('param.schoolName');
            } else {
                $memberModel = new MemberModel();
                $memberInfo = $memberModel->getInfoById(session('memberId'));
            }
            $this->assign([
                'memberInfo' => $memberInfo
            ]);

            return $this->fetch('/member-edit');
        }
    }
}
