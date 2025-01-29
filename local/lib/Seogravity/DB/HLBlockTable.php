<?php

namespace Seogravity\DB;

use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\Entity;

class HLBlockTable
{
    protected $hlblockId;
    protected $entityDataClass;

    public function __construct($hlblockId)
    {
        $this->hlblockId = $hlblockId;
        $this->initDataClass();
    }

    protected function initDataClass()
    {
        if ($this->hlblockId) {
            if (\Bitrix\Main\Loader::includeModule('highloadblock')) {
                $hlblock = HighloadBlockTable::getById($this->hlblockId)->fetch();
                $entity = HighloadBlockTable::compileEntity($hlblock);
                $this->entityDataClass = $entity->getDataClass();
            } else {
                throw new \Exception("Не удалось загрузить модуль highloadblock.");
            }
        }
    }

    public function add($fields)
    {
        $result = $this->entityDataClass::add($fields);
        if (!$result->isSuccess()) {
            return $result->getErrorMessages(); // возвращаем ошибки, если есть
        }
        return true;
    }

    public function update($id, $fields)
    {
        $result = $this->entityDataClass::update($id, $fields);
        return $result->isSuccess();
    }

    public function delete($id)
    {
        $result = $this->entityDataClass::delete($id);
        return $result->isSuccess();
    }

    public function getList($params = [])
    {
        return $this->entityDataClass::getList($params)->fetchAll();
    }
}
