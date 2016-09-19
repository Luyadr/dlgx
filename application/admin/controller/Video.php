<?php
namespace app\admin\controller;

use app\admin\model\VideoModel;
use app\admin\model\RoleModel;

class Video extends Base
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
                $where['video_name'] = ['like', '%' . $param['searchText'] . '%'];
            }
            $video = new VideoModel();
            $selectResult = $video->getVideosByWhere($where, $offset, $limit);


            foreach($selectResult as $key=>$vo){

                $selectResult[$key]['video_release_time'] = date('Y-m-d H:i:s', $vo['video_release_time']);

                $operate = [
                    '编辑' => url('video/edit', ['id' => $vo['id']]),
//                    '删除' => "javascript:del('".$vo['id']."')"
                ];

                $selectResult[$key]['operate'] = showOperate($operate);

            }

            $return['total'] = $video->getAllVideos($where);  //总数据
            $return['rows'] = $selectResult;

            return json($return);
        }

        return $this->fetch();
    }


    //编辑视频
    public function edit()
    {
        $video = new VideoModel();

        if(request()->isPost()){

            $param = input('post.');
            $param = parseParams($param['data']);
            $param['video_release_time'] = strtotime($param['video_release_time']);
            $flag = $video->editVideo($param,'VideoValidate');

            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

        $id = input('param.id');
        $info = $video->getOneVideo($id);
        $info['video_release_time'] = date('Y-m-d H:i:s', $info['video_release_time']);
        $this->assign([
            'video' => $info
        ]);
        return $this->fetch();
    }

    //删除角色
    public function del()
    {
        $id = input('param.id');

        $role = new VideoModel();
        $flag = $role->delVideo($id);
        return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
    }
}