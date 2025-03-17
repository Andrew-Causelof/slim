<?php

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Context;
use Bitrix\Main\Loader;

Loc::loadMessages(__FILE__);

class Auth extends CBitrixComponent
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

        $templateName = $this->GetTemplateName();

        switch ($templateName) {
            case 'login':
                //$this->setupDatasForMainBanner();
                break;

            default:
                //throw new \Exception('Unknown template name: ' . $templateName);
        }


        $this->includeComponentTemplate('');
    }
}
