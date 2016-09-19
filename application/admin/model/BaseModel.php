<?php
namespace app\admin\model;

use think\Model;

class BaseModel extends Model
{
    /**
     * 插入
     * @param $param
     * @param $validateName
     * @return array
     */
    public function insert($param, $validateName)
    {
        try{
            $result =  $this->validate($validateName)->save($param);

            if(FALSE === $result){
                // 验证失败 输出错误信息
                return ['code' => -1, 'data' => '', 'msg' => $this->getError()];
            }else{
                return ['code' => 1, 'data' => '', 'msg' => '添加成功'];
            }
        }catch( PDOException $e){
            return ['code' => -2, 'data' => '', 'msg' => $e->getMessage()];
        }
    }
    /**
     * 编辑
     * @param $param
     * @param $validateName
     * @return array
     */
    public function edit($param, $validateName)
    {
        try{
            $result =  $this->validate($validateName)->save($param, ['id' => $param['id']]);
            if(FALSE === $result){
                // 验证失败 输出错误信息
                return ['code' => -1, 'data' => '', 'msg' => $this->getError()];
            }else{
                return ['code' => 1, 'data' => '', 'msg' => '编辑成功'];
            }
        }catch( PDOException $e){
            return ['code' => -2, 'data' => '', 'msg' => $e->getMessage()];
        }
    }
    /**
     * 根据条件更新信息
     * @param $param
     * @param $validateName
     * @param $where
     * @return array
     */
    public function updateByWhere($param, $validateName, $where)
    {
        try{
            $result =  $this->validate($validateName)->update($param, $where);
            if(FALSE === $result){
                // 验证失败 输出错误信息
                return ['code' => -1, 'data' => '', 'msg' => $this->getError()];
            }else{
                return ['code' => 1, 'data' => '', 'msg' => '更新成功'];
            }
        }catch( PDOException $e){
            return ['code' => -2, 'data' => '', 'msg' => $e->getMessage()];
        }
    }
    /**
     * 删除
     * @param $id
     * @return array
     */
    public function del($id)
    {
        try{
            $this->where('id', $id)->delete();
            return ['code' => 1, 'data' => '', 'msg' => '删除成功'];
        }catch( PDOException $e){
            return ['code' => -2, 'data' => '', 'msg' => $e->getMessage()];
        }
    }
    /**
     * 根据条件获取数据列表
     * @param $where
     * @param $offset
     * @param $limit
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getListByWhere($where, $offset, $limit)
    {
        return $this->where($where)->limit($offset, $limit)->order('id desc')->select();
    }
    /**
     * 根据ID获取信息
     * @param $id
     * @return array
     */
    public function getInfoById($id)
    {
        return $this->where('id', $id)->find();
    }
    /**
     * 根据条件获取数据数量
     * @param $where
     * @return array
     */
    public function getCounts($where)
    {
        return $this->where($where)->count();
    }
    /**
     * 根据条件获取所有数据
     * @param $where
     * @return array
     */
    public function getAllByWhere($where)
    {
        return $this->where($where);
    }
    /**
     * 获取所有数据
     */
    public function getAll()
    {
        return $this->select();
    }
}
