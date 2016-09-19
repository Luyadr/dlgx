<?php
namespace app\admin\model;

class ClubModel extends BaseModel
{
    protected $table = 'dlgx_club_apply';

    /**
     * 根据条件获取用户列表
     * @param $where
     * @param $offset
     * @param $limit
     */
    public function getClubsByWhere($where, $offset, $limit)
    {
        return $this->field('dlgx_club_apply.*,club_name')
            ->where($where)->limit($offset, $limit)->order('id desc')->select();
    }
	public function getAllClubs()
   {
	     return $this->select();
   }
   public function insertClub($param, $validateName)
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
	 public function getOneClub($id)
   {
	     return $this->where('id', $id)->find();
   }
   /**
     * 编辑
     * @param $param
     * @param $validateName
     * @return array
     */
    public function editClub($param, $validateName)
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
     * 删除
     * @param $id
     * @return array
     */
    public function delClub($id)
    {
        try{
            $this->where('id', $id)->delete();
            return ['code' => 1, 'data' => '', 'msg' => '删除成功'];
        }catch( PDOException $e){
            return ['code' => -2, 'data' => '', 'msg' => $e->getMessage()];
        }
    }
}