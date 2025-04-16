<?php

namespace Api\Services;

use Bitrix\Main\Loader;
use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\UserTable;
use Bitrix\Main\UserGroupTable;

class PatientService
{
    public function getPatients($page = 1, $limit = 20, $letter = '')
    {
        Loader::includeModule('main');

        $offset = ($page - 1) * $limit;
        $groupId = 6; // ID группы Пациенты

        $query = UserTable::query()
            ->setSelect(['ID', 'NAME', 'LAST_NAME', 'SECOND_NAME'])
            ->registerRuntimeField(
                'UG', // псевдо-поле для связи с таблицей групп пользователей
                [
                    'data_type' => UserGroupTable::class,
                    'reference' => [
                        '=this.ID' => 'ref.USER_ID',
                    ],
                ]
            )
            ->setFilter([
                '=UG.GROUP_ID' => $groupId,
                'ACTIVE' => 'Y',
            ])
            ->setOrder(['LAST_NAME' => 'ASC', 'NAME' => 'ASC'])
            ->setLimit($limit)
            ->setOffset($offset);

        if (!empty($letter)) {
            $query->whereLike('LAST_NAME', "{$letter}%"); // Фамилия начинается с буквы
        }

        $result = $query->exec();

        $patients = [];
        while ($user = $result->fetch()) {
            $patients[] = [
                'id' => (int)$user['ID'],
                'name' => $user['NAME'],
                'lastname' => $user['LAST_NAME'],
                'secondname' => $user['SECOND_NAME']
            ];
        }

        return $patients;
    }

    public function countPatients($letter = '')
    {
        Loader::includeModule('main');

        $groupId = 6; // ID группы Пациенты

        $query = UserTable::query()
            ->registerRuntimeField(
                'UG',
                [
                    'data_type' => UserGroupTable::class,
                    'reference' => [
                        '=this.ID' => 'ref.USER_ID',
                    ],
                ]
            )
            ->setFilter([
                '=UG.GROUP_ID' => $groupId,
                'ACTIVE' => 'Y',
            ])
            ->setSelect(['ID']);

        if (!empty($letter)) {
            $query->whereLike('LAST_NAME', "{$letter}%");
        }

        $result = $query->exec();

        $count = 0;
        while ($result->fetch()) {
            $count++;
        }

        return $count;
    }

    public function getAvailableLetters()
    {
        Loader::includeModule('main');

        $groupId = 6; // ID группы Пациенты

        $query = UserTable::query()
            ->setSelect(['LAST_NAME'])
            ->registerRuntimeField(
                'UG',
                [
                    'data_type' => UserGroupTable::class,
                    'reference' => [
                        '=this.ID' => 'ref.USER_ID',
                    ],
                ]
            )
            ->setFilter([
                '=UG.GROUP_ID' => $groupId,
                'ACTIVE' => 'Y',
                '!LAST_NAME' => false, // Только если фамилия указана
            ]);

        $result = $query->exec();

        $letters = [];

        while ($user = $result->fetch()) {
            $lastName = $user['LAST_NAME'];
            if (!empty($lastName)) {
                $firstLetter = mb_substr($lastName, 0, 1, 'UTF-8'); // Первая буква фамилии
                $letters[] = mb_strtoupper($firstLetter, 'UTF-8');  // Привести к верхнему регистру
            }
        }

        // Оставляем только уникальные буквы
        $letters = array_unique($letters);
        sort($letters); // Отсортировать по алфавиту

        return array_values($letters); // Перенумеровать массив
    }
}
