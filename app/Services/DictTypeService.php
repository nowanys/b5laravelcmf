<?php

namespace App\Services;

use App\Models\DictType;
use App\Validates\DictTypeValidate;


/**
 * 字典分类
 * Class DictTypeService
 * @package App\Services
 */
class DictTypeService extends BaseService
{
    public function __construct(bool $loadValidate = true)
    {
        $this->setModel(new DictType());
        $loadValidate && $this->setValidate(new DictTypeValidate());
    }

    /**
     * 获取字典类型列表
     * @return mixed
     */
    public function getTypeList()
    {
        return $this->getAll([], ['type', 'name'], [], '', [['listsort', 'asc']]);
    }

    /**
     * 指定删除字段
     * @return array
     */
    public function drop()
    {
        return parent::drop([], 'type'); // TODO: Change the autogenerated stub
    }

    /**
     * 删除类型成功后，删除类型下的数据
     * @param $data
     * @return bool
     */
    public function after_drop($data)
    {
        (new DictDataService())->drop($data, 'type');
        return parent::after_drop($data); // TODO: Change the autogenerated stub
    }
}
