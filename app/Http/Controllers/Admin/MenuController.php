<?php

namespace App\Http\Controllers\Admin;


use App\Services\MenuService;
use Illuminate\Http\Request;

class MenuController extends Backend
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->service = new MenuService();
    }

    public function index()
    {
        if(IS_POST){
            return $this->service->getList(true);
        }
        return parent::index(); // TODO: Change the autogenerated stub
    }

    public function add()
    {
        if(IS_GET){
            $parent_name='主目录';
            $parent_id=request()->input('id',0);
            if($parent_id){
                $parentInfo=$this->service->info($parent_id);
                if($parentInfo){
                    $parent_name=$parentInfo['name'];
                }else{
                    $parent_id=0;
                }
            }
            view()->share('parent_id',$parent_id);
            view()->share('parent_name',$parent_name);
            view()->share('typeList',$this->service->getModel()->typeArr);
        }
        return parent::add(); // TODO: Change the autogenerated stub
    }

    public function edit()
    {
        IS_GET && view()->share('typeList',$this->service->getModel()->typeArr);
        return parent::edit(); // TODO: Change the autogenerated stub
    }

    public function tree(){
        if(IS_POST){
            return $this->service->getTree();
        }else{
            $id = request()->input('id', 0);
            view()->share('menuId',$id);
            return $this->render();
        }
    }
}
