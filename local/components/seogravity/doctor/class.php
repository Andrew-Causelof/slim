<?php

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Context;
use Bitrix\Main\Loader;

Loc::loadMessages(__FILE__);

class Doctor extends CBitrixComponent
{


    public function __construct($component = null)
    {
        parent::__construct($component);
    }

    public function executeComponent()
    {
        if (!Loader::includeModule("iblock")) {
            $this->__ShowError("Модуль инфоблоков не установлен");
            return;
        }

        $this->includeComponentTemplate('');
    }
}
