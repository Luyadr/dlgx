<?php
namespace app\admin\controller;

use app\admin\model\NodeModel;

class Node extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        if(request()->isAjax()){

            $param = input('param.');

            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            $where = [];
            if (isset($param['searchText']) && !empty($param['searchText'])) {
                $where['node_name'] = ['like', '%' . $param['searchText'] . '%'];
            }
            $node = new NodeModel();
            $selectResult = $node->getListByWhere($where, $offset, $limit);

            foreach($selectResult as $key=>$vo){

                if(1 == $vo['id']){
                    $selectResult[$key]['operate'] = '';
                    continue;
                }

                $operate = [
                    '编辑' => url('node/edit', ['id' => $vo['id']]),
                    '删除' => "javascript:del('".$vo['id']."')",
                ];
                $selectResult[$key]['operate'] = showOperate($operate);

            }

            $return['total'] = $node->getCounts($where);  //总数据
            $return['rows'] = $selectResult;

            return json($return);
        }

        return $this->fetch();
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function add()
    {
		if(request()->isPost()){

            $param = input('param.');
            $param = parseParams($param['data']);

            $node = new NodeModel();
	
            $flag = $node->insert($param,'NodeValidate');

            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }
        $node = new NodeModel();
        $this->assign([
            'node' => $node->getListByWhere(),
            'status' => config('user_status')
        ]);
        return $this->fetch();
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        if($request->isPost()){

            $param = input('param.');
            $param = parseParams($param['data']);

            $node = new NodeModel();
            $flag = $node->insert($param,'NodeValidate');

            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

        return $this->fetch();
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        $node = new NodeModel();

        if(request()->isPost()){

            $param = input('post.');
            $param = parseParams($param['data']);

            $flag = $node->edit($param,'NodeValidate');

            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

        $id = input('param.id');
        $this->assign([
            'nodes' => $node->getListByWhere(),
            'node' => $node->getInfoById($id)
        ]);
		
        return $this->fetch();
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request,$id)
    {
        $node = new NodeModel();

        if(request()->isPost()){

            $param = input('post.');
            $param = parseParams($param['data']);

            $flag = $node->edit($param,'NodeValidate');

            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

        $id = input('param.id');
        $this->assign([
            'nodes' => $node->getListByWhere(),
            'node' => $node->getInfoById($id)
        ]);
        return $this->fetch();
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function del($id)
    {
        $node = new NodeModel();
        $flag = $node->del($id);
        return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
    }
}
