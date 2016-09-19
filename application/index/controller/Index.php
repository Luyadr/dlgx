<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\MemberModel;
use app\index\model\NoticeModel;
use app\index\model\ActivityModel;
use app\index\model\ActJoinModel;
use app\index\model\VideoModel;

class Index extends Controller
{
    public function index()
    {
        session('memberId',4);
        session('memberIcon','http://wx.qlogo.cn/mmopen/NXsNg5c1niaXCcjXCBBkUDDHeEyMaibT422ydJV81PqWP2pBdQTPLOEeaAUdfOOLicf8F6bjLeQV0oEKbTIBjVX8a2HomPIcbFc/0');
        session('memberName','123');
        $this->redirect('index/show');

        //第一步：请求code
        $appId = 'wxd53d2b1ef188dca7';//大乐个学
//        $appId = 'wxafea1eaaaf3b18ac';
        $redirectUri = 'http://lya.tunnel.qydev.com/dlgx/public/index.php/index/index/callback';
        $state = md5(uniqid(rand(), TRUE));
        session('state',$state);
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appId
            .'&redirect_uri='.$redirectUri.'&response_type=code&scope=snsapi_userinfo&state='.$state .'#wechat_redirect';
        $this->redirect($url);
    }

    public function callback() {
        if(input('param.state') == session('state')) {
            $code = input('param.code');
            if(!isset($code)) {
                //用户没有同意授权
                $this->error('授权失败！');
                exit;
            }
            $appId = 'wxd53d2b1ef188dca7';//大乐个学
            $secret = 'aafdb067ff2aef548c50541392cf44b8';
//            $appId = 'wxafea1eaaaf3b18ac';
//            $secret = '370a57f55cf6d23bcfcae76034b0fa97';
            $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?grant_type=authorization_code&appid='.$appId.'&secret='.$secret .'&code='.$code;
            $result = $this->get_url_contents($url);
            if(strpos($result, 'errcode') != FALSE) {
                $msg = json_decode($result);
                if (isset($msg->errcode)) {
                    $this->error('error:'.$msg->errcode);
                    $this->error('msg:'.$msg->errmsg);
                    exit;
                }
            }
            $params = json_decode($result);
            session('accessToken', $params->access_token);
            session('openId', $params->openid);

            $userInfo = $this->get_user_info();
            $memberModel = new MemberModel();
            $hasMember = $memberModel->getListByWhere(array('member_openid' => $userInfo['openid']));
            if(empty($hasMember)) {
                $member = [];
                $member['member_openid'] = $userInfo['openid'];
                $member['member_icon'] = $userInfo['headimgurl'];
                $member['member_name'] = $userInfo['nickname'];
                $member['member_sex'] = $userInfo['sex'];
                $member['last_login_ip'] = request()->ip();
                $member['login_times'] = 1;
                $member['member_create_time'] = time();
                $member['last_login_time'] = $member['member_create_time'];
                $memberId = db('member')->insertGetId($member);
                session('memberId',$memberId);
            } else {
                $member = [];
                $member['id'] = $hasMember[0]['id'];
                $member['last_login_time'] = time();
                $member['last_login_ip'] = request()->ip();
                $member['login_times'] = $hasMember[0]['login_times'] + 1;
                db('member')->update($member);
                session('memberId',$hasMember[0]['id']);
            }
            session('memberIcon',$userInfo['headimgurl']);
            session('memberName',$userInfo['nickname']);

            $this->redirect('index/show');
        } else {
            $this->error('The state does not match. You may be a victim of CSRF.');
            exit;
        }
    }

    public function show()
    {
        $noticeWhere = [];
        $noticeWhere['notice_from_id'] = 0;
        $noticeWhere['notice_release_time'] = ['>', 0];
        $noticeField = 'id,notice_title,notice_release_time,notice_content';
        $noticeModel = new NoticeModel();
        $noticeList = $noticeModel->getListByWhere($noticeWhere, $noticeField, 0, 1);
        foreach($noticeList as $key => $vo){
            $noticeList[$key]['notice_title'] = mb_substr($vo['notice_title'], 0, 16);
            $noticeList[$key]['notice_release_time'] = date('m-d H:i', $vo['notice_release_time']);
            $noticeList[$key]['notice_content'] = mb_substr($vo['notice_content'], 0, 500);
        }
        $this->assign([
            'noticeList' => $noticeList
        ]);

        $activityWhere = [];
        $activityWhere['act_from_id'] = 0;
        $activityWhere['act_release_time'] = ['>', 0];
        $activityField = 'id,act_name,act_list_img,act_release_time,act_start_time,act_end_time';
        $activityModel = new ActivityModel();
        $activityList = $activityModel->getListByWhere($activityWhere, $activityField, 0, 1);

        $actJoinModel = new ActJoinModel();
        $memberId = session('memberId');

        foreach($activityList as $key => $vo){

            $counts = $actJoinModel->getCounts(array('act_id' => $vo['id'], 'member_id' => $memberId));
            if(empty($counts)) {
                $activityList[$key]['act_apply_status'] = 0;
            } else {
                $activityList[$key]['act_apply_status'] = 1;
            }

            $stime = $vo['act_start_time'];
            $etime = $vo['act_end_time'];
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

        $videoWhere = [];
        $videoWhere['video_release_time'] = ['>', 0];;
        $videoField = 'id,video_name,video_url,video_release_time';
        $videoModel = new VideoModel();
        $videoList = $videoModel->getListByWhere($videoWhere, $videoField, 0, 1);
        foreach($videoList as $key => $vo){
            $videoList[$key]['video_release_time'] = date('m-d H:i', $vo['video_release_time']);
        }
        $this->assign([
            'videoList' => $videoList
        ]);

        return $this->fetch('/index');
    }

    function get_url_contents($url)
    {
        if (ini_get('allow_url_fopen') == 1) return file_get_contents($url);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    function get_user_info()
    {
        $accessToken = session('accessToken');
        $openId = session('openId');
        $url = 'https://api.weixin.qq.com/sns/userinfo?'.'access_token='.$accessToken.'&openid='.$openId;
        $info = $this->get_url_contents($url);
        $info = json_decode($info, true);
        return $info;
    }
}