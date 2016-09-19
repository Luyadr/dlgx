<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\ClubModel;
use app\index\model\SendCodeModel;
use app\index\model\MemberModel;
use org\Api\Alidayu\TopClient;
use org\Api\Alidayu\Request\AlibabaAliqinFcSmsNumSendRequest;

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

    public function sendCode()
    {
        if(request()->isAjax()) {
            $memberId = session('memberId');
            $code = rand(1000,9999);
            $memberTel = input('param.memberTel');
            $sendCodeModel = new SendCodeModel();
            $codeList = $sendCodeModel->getListByWhere(array('member_id' => $memberId));
            if(empty($codeList)) {
                $params = [];
                $params['member_id'] = $memberId;
                $params['msg_code'] = $code;
                $params['send_time'] = time();
                $params['today'] = strtotime(date('Y-m-d', time()));
                $params['send_times'] = 1;
                $params['check_times'] = 0;
                $sendCodeModel->insert($params);
            } else {
                $codeInfo = $codeList[0];
                if(time() - $codeInfo['send_time'] < 60) {
                    return FALSE;
                }
                if(strtotime(date('Y-m-d', time())) == $codeInfo['today']) {
                    if($codeInfo['send_times'] > 15) {
                        return json(['code' => -1, 'msg' => '您今天已获取超过15条验证码，请明天再试！']);
                    } else {
                        $params = [];
                        $params['member_id'] = $memberId;
                        $params['msg_code'] = $code;
                        $params['send_time'] = time();
                        $params['send_times'] = $codeInfo['send_times'] + 1;
                        $sendCodeModel->updateByWhere($params, '', array('member_id' => session('memberId')));
                    }
                } else {
                    $params = [];
                    $params['member_id'] = $memberId;
                    $params['msg_code'] = $code;
                    $params['send_time'] = time();
                    $params['today'] = strtotime(date('Y-m-d', time()));
                    $params['send_times'] = 1;
                    $sendCodeModel->updateByWhere($params, '', array('member_id' => session('memberId')));
                }
            }

            require_once APP_PATH . "../extend/org/Api/Alidayu/TopSdk.php";

            $c = new TopClient;
            $c->appkey = '23460524';
            $c->secretKey = '22374c6567b55471012354017f22ae07';

            $req = new AlibabaAliqinFcSmsNumSendRequest;
            $req->setExtend($memberId);
            $req->setSmsType("normal");
            $req->setSmsFreeSignName("大乐个学");
            $req->setSmsParam("{\"code\":\"$code\"}");
            $req->setRecNum($memberTel);
            $req->setSmsTemplateCode("SMS_15115232");

            $resp = $c->execute($req);

            if($resp->result->success) {
                return json(['code' => 1, 'msg' => '验证码发送成功，请注意查收！']);
            } else {
                return json(['code' => 0, 'msg' => '验证码发送失败！']);
            }
        }
    }

    public function edit()
    {
        if(request()->isAjax()) {
            $params = input('param.');
            $params = parseParams($params['data']);

            $sendCodeModel = new SendCodeModel();
            $codeList = $sendCodeModel->getListByWhere(array('member_id' => session('memberId')));
            if(!empty($codeList)) {
                $codeInfo = $codeList[0];
                if($codeInfo['check_times'] > 5) {
                    return json(['code' => -3, 'msg' => '验证次数过多，请重新获取验证码！']);
                } else {
                    $sendCodeModel->updateByWhere(array('check_times' => $codeInfo['check_times'] + 1), '', array('member_id' => session('memberId')));
                    if($codeInfo['msg_code'] == $params['code']) {
                        unset($params['code']);
                        $memberModel = new MemberModel();
                        $flag = $memberModel->edit($params, 'MemberValidate');
                        return json(['code' => $flag['code'], 'msg' => $flag['msg']]);
                    } else {
                        return json(['code' => -2, 'msg' => '验证码错误！']);
                    }
                }
            } else {
                return json(['code' => -1, 'msg' => '验证码错误！']);
            }
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
