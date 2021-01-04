<?php

namespace App\Services;

use App\Models\Admin;
use App\Validates\AdminValidate;


/**
 * 人员管理
 * Class AdminService
 * @package App\Services
 */
class AdminService extends BaseService
{
    public function __construct(bool $loadValidate = true)
    {
        $this->setModel(new Admin());
        $loadValidate && $this->setValidate(new AdminValidate());
    }

    public function getList($all = false)
    {
        $where=[];
        $structId=intval(request()->input('structId'));

        if($structId>0){
            $userList=(new AdminStructService())->getUsersByStruct($structId);
            if(!$userList){
                return message('操作成功', true, [], 0, '', ['total' => 0]);
            }else{
                $where=[['id','in',$userList]];
            }
        }
        return parent::getList($all,$where); // TODO: Change the autogenerated stub
    }

    /**
     * 人员信息返回关联信息
     * @param $id
     * @param bool $isArray
     * @return mixed
     */
    public function info($id, bool $isArray = true)
    {
        $info=parent::info($id, $isArray);
        if($info){
            //组织架构信息
            $structIdStr='';
            $structNameStr='';
            $structList=(new AdminStructService())->getListByAdmin($info['id']);
            if($structList){
                $structIdArr=[];
                $structNameArr=[];
                foreach ($structList as $structInfo){
                    $structIdArr[]=$structInfo['id'];
                    $structNameArr[]=$structInfo['name'];
                }
                $structIdStr=implode(',',$structIdArr);
                $structNameStr=implode(',',$structNameArr);
            }
            $info['structid']=$structIdStr;
            $info['structname']=$structNameStr;
            $info['structlist']=$structList?:[];

            //角色分组
            $roleIdStr='';
            $roleNameStr='';
            $roleList=(new AdminRoleService())->getListByAdmin($info['id']);
            if($roleList){
                $roleIdArr=[];
                $roleNameArr=[];
                foreach ($roleList as $roleInfo){
                    $roleIdArr[]=$roleInfo['id'];
                    $roleNameArr[]=$roleInfo['name'];
                }
                $roleIdStr=implode(',',$roleIdArr);
                $roleNameStr=implode(',',$roleNameArr);
            }
            $info['roleid']=$roleIdStr;
            $info['rolename']=$roleNameStr;
            $info['rolelist']=$roleList?:[];

        }
        return $info;
    }

    /**
     * 超管不可以删除
     * @return array
     */
    public function drop()
    {
        $data = request()->all();
        if ($data && isset($data['ids'])) {
            $id = $data['ids'];
            if (is_array($id)) {
                $idArr = $id;
            } else {
                $id = trim($id, ',');
                $idArr = explode(',', $id);
            }
            if (in_array(1, $idArr)) {
                return message('超级管理员无法删除', false);
            }
        }
        return parent::drop(); // TODO: Change the autogenerated stub
    }

    public function add()
    {
        if(IS_POST){
            $data = request()->input();
            unset($data['struct']);
            unset($data['role']);
            unset($data['roles']);
            return parent::add($data); // TODO: Change the autogenerated stub
        }
        return parent::add(); // TODO: Change the autogenerated stub
    }

    public function after_add($data)
    {
        $struct=request()->input('struct','');
        (new AdminStructService())->update($data['id'],$struct);

        $roles=request()->input('roles','');
        (new AdminRoleService())->update($data['id'],$roles);

        return parent::after_add($data); // TODO: Change the autogenerated stub
    }

    public function edit()
    {
        if(IS_POST){
            $data = request()->input();
            unset($data['struct']);
            unset($data['role']);
            unset($data['roles']);
            return parent::edit($data); // TODO: Change the autogenerated stub
        }
        return parent::edit(); // TODO: Change the autogenerated stub
    }
    public function after_edit($data)
    {
        $struct=request()->input('struct','');
        (new AdminStructService())->update($data['id'],$struct);

        $roles=request()->input('roles','');
        (new AdminRoleService())->update($data['id'],$roles);

        return parent::after_edit($data); // TODO: Change the autogenerated stub
    }
}
