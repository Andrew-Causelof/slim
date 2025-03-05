<?php

namespace Seogravity\User;

use Bitrix\Main\UserTable;
use Bitrix\Main\Application;
use Bitrix\Main;

class User
{
    public $userId;
    public $fields;

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

    /**
     * Обновляет пользовательские поля пользователя
     *
     * @param array $fields Массив вида ['UF_FIELD_NAME' => 'Новое значение']
     * @return bool|string
     */
    function updateUserFields(array $fields)
    {
        global $USER;

        if (!$this->userId || empty($fields)) {
            return "Ошибка: ID пользователя не задан или массив данных пуст.";
        }

        // Проверяем, что ключи начинаются с "UF_" (чтобы не обновлять системные поля)
        $filteredFields = array_filter($fields, function ($key) {
            return strpos($key, 'UF_') === 0;
        }, ARRAY_FILTER_USE_KEY);

        if (empty($filteredFields)) {
            return "Ошибка: Нет корректных пользовательских полей для обновления.";
        }

        $user = new \CUser;
        $result = $user->Update($this->userId, $filteredFields);

        if ($result) {
            return true; // Успешное обновление
        } else {
            return "Ошибка обновления: " . $user->LAST_ERROR;
        }
    }
}
