<?php

namespace Seogravity\User;

use Bitrix\Main\UserTable;
use Bitrix\Main\Application;
use Bitrix\Main;

class User
{
    public $userId;
    public $user;

    function __construct($userId)
    {
        $this->userId = $userId;
        $this->user = $this->getUserById($userId);
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
}
