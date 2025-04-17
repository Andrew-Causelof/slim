<?php

namespace Seogravity\User;

use Bitrix\Main\UserTable;
use Bitrix\Main\Application;
use Bitrix\Main;
use \Seogravity\DB\HLBlockTable;

class User
{
    public $userId;
    public $fields;
    const USER_GROUP_DOCTOR = 5;
    const USER_GROUP_PATIENT = 6;

    function __construct($userId)
    {
        $this->userId = $userId;
        $this->fields = $this->getUserById($userId);
    }

    function getUserById($userId)
    {

        $userId = intval($userId);
        if ($userId <= 0) {
            return false;
        }

        // Получаем пользователя
        $user = \CUser::GetByID($userId);
        if ($userData = $user->Fetch()) {
            // Добавляем пользовательские поля
            $customFields = [];
            $res = UserTable::getList([
                'select' => ['*', 'UF_*'], // Загружаем пользовательские поля
                'filter' => ['ID' => $userId],
            ]);

            if ($userCustom = $res->fetch()) {
                $customFields = array_filter($userCustom, function ($key) {
                    return strpos($key, 'UF_') === 0;
                }, ARRAY_FILTER_USE_KEY);
            }

            // Объединяем стандартные и пользовательские поля
            return array_merge($userData, $customFields);
        }

        return false;
    }


    function isPatient()
    {
        global $USER;

        return $USER->IsAuthorized() && in_array(self::USER_GROUP_PATIENT, $USER->GetUserGroupArray());
    }

    function isDoctor()
    {
        global $USER;

        return $USER->IsAuthorized() && in_array(self::USER_GROUP_DOCTOR, $USER->GetUserGroupArray());
    }

    public function redirectIfAuthorized()
    {
        if ($this->isPatient()) {
            LocalRedirect('/patient/');
            exit;
        }

        if ($this->isDoctor()) {
            LocalRedirect('/doctor/');
            exit;
        }
    }

    public function getTableID()
    {
        $hlBlockTable = new HLBlockTable(HLBLOCK_ID_PATIENT_DATAS);

        $result = $hlBlockTable->getList([
            'filter' => ['UF_USER_ID' => $this->userId],
            'select' => ['ID', 'UF_USER_ID', 'UF_USER_DATA'], // Указываем нужные поля
            'limit' => 1
        ]);

        return !empty($result) ? $result[0]['ID'] : null;
    }
}
