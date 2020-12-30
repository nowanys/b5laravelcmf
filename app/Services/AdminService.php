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
    /**
     * 构造方法
     * @author zongjl
     * @date 2019/5/23
     */
    public function __construct()
    {
        $this->setModel(new Admin());
        $this->setValidate(new AdminValidate());
    }

    /**
     * 超管不可以删除
     * @return array
     */
    public function drop()
    {
        $data = request()->all();
        if($data && isset($data['ids'])){
            $id=$data['ids'];
            if(is_array($id)){
                $idarr=$id;
            }else{
                $id=trim($id,',');
                $idarr=explode(',',$id);
            }
            if(in_array(1,$idarr)){
                return message('超级管理员无法删除', false);
            }
        }
        return parent::drop(); // TODO: Change the autogenerated stub
    }
}
