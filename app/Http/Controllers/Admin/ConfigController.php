<?php

namespace App\Http\Controllers\Admin;

use App\Services\ConfigService;
use Illuminate\Http\Request;

class ConfigController extends Backend
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->service = new ConfigService();
        if(IS_GET && !IS_AJAX){
            view()->share('stylelist',$this->service->styleList());
            view()->share('grouplist',$this->service->getConfig('sys_config_group'));
        }
    }
}
