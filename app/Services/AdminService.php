<?php
namespace App\Services;

use App\Models\Admin;


/**
 * 人员管理
 * Class AdminService
 * @package App\Services
 */
class AdminService extends BaseService
{
    /**
     * 构造方法
     * @author zongjl
     * @date 2019/5/23
     */
    public function __construct()
    {
        $this->setModel(new Admin());
    }
    public function getInfo($id)
    {
        $info=parent::getInfo($id);
        if($info){
            $info['group_name']='';
            if($info['group_id']){
                $groupInfo=(new AuthgroupService())->getInfo($info['group_id']);
                $info['group_name']=$groupInfo?$groupInfo['name']:'';
            }
        }
        return $info;
    }

    /**
     * 获取数据列表
     * @return array
     * @since 2020/8/30
     * @author 牧羊人
     */
    public function getList()
    {
        $param = request()->all();

        // 查询条件
        $map = [];

        // 真实姓名
        $realname = isset($param['realname']) ? $param['realname'] : '';
        if ($realname) {
            $map[] = ['realname', 'like', "%{$realname}%"];
        }
        return parent::getList($map,[['id','asc']]); // TODO: Change the autogenerated stub
    }

    public function edit()
    {
        $data = request()->all();
        if($data['password']){
            $data['password']=get_password($data['password']);
        }else{
            if($data['id']){
                unset($data['password']);
            }else{
                $data['password']=get_password('123456');
            }
        }
        $data['realname']=$data['realname']?:$data['username'];
        return parent::edit($data); // TODO: Change the autogenerated stub
    }

}
