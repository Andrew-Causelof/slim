<?php

namespace Seogravity\User;

use Bitrix\Main\UserTable;
use Bitrix\Main\Loader;
use Seogravity\DB\HLBlockTable;



class UserData
{

    protected static $hlblockId = HLBLOCK_ID_PATIENT_DATAS;

    // Маппинг полей из JSON в стандартные поля пользователя

    private static $fieldMap  = [
        "activeTab" => null,
        "gender" => "PERSONAL_GENDER",
        "firstname" => "NAME",
        "lastname" => "LAST_NAME",
        "thirdname" => "SECOND_NAME",
        "birthday" => "PERSONAL_BIRTHDAY",
        "height" => "UF_HEIGHT",
        "weight" => "UF_WEIGHT",
        "phone" => "PERSONAL_PHONE",
        "phone2" => "PERSONAL_MOBILE",
        "email" => "EMAIL",
        "polis" => "UF_POLIS",
        "polisRegion" => null, //@TODO as  list id
        "snils" => "UF_SNILS",
        "passport" => "UF_PASSPORT",
        "passportDate" => "UF_PASSPORT_DATE", //@TODO as  string 
        "passportFrom" => "UF_PASSPORT_BY",
        "city" => "PERSONAL_CITY",
        "address" => "UF_PASSPORT_ADDRESS",
        "chronicDiseases" => "UF_CHRONIC_DISEASES",
        "diseaseList"  => null,
        "medications" => "UF_MEDICATIONS",
        "medicationList" => null,
        "alergyList" => null,
        "infectionList" => null,
        "badHabbitsList" => null,
        "comment" => "UF_COMMENT",
        "surgeries" => "UF_SURGERIES",
        "surgeriesComment" => "UF_SURGERIES_COMMENT",
        "alergy" => "UF_ALERGY",
        "infection" => "UF_INFECTION",
        "inheritanceDiseasesComment" => "UF_INHERITANCE_DISEASES_COMMENT",
        "badHabbits" => "UF_BAD_HABBITS",
        "pregnant" => "UF_PREGNANT",
        "sickLeave" => "UF_SICK_LEAVE",
    ];

    private static $files = [
        "passport" => 'UF_FILES_PASSPORT',
        "polis_files" => 'UF_FILES_POLIS',
        "snils_files" => 'UF_FILES_SNILS',
        "general_files" => 'UF_FILES_CBC',
        "coagulogram_files" => 'UF_COAGULOGRAM',
        "blood-biochemical_files" => 'UF_BIOCHEMICAL',
        "blood-infectious_files" => 'UF_INFECTIOUS',
        "blood-group_files" => 'UF_BLOOD_GROUP',
        "blood-phenotyping_files" => 'UF_PHENOTYPING',
        "urine-general_files" => 'UF_URINE',
        "covid_files" => 'UF_COVID'
    ];

    public static function updateHLFromUser($userId)
    {
        Loader::includeModule('highloadblock');

        $user = UserTable::getById($userId)->fetch();

        if (!$user) {
            return false;
        }

        // Формируем JSON
        $userData = [];
        foreach (self::$fieldMap as $jsonField => $userField) {
            if (isset($user[$userField])) {
                $userData[$jsonField] = $user[$userField];
            }
        }

        // Обновляем запись в HL
        $hl = new HLBlockTable(self::$hlblockId);

        $existing = $hl->getRow([
            'filter' => ['UF_USER_ID' => $userId]
        ]);

        if ($existing) {
            $hl->update($existing['ID'], [
                'UF_USER_DATA' => json_encode($userData, JSON_UNESCAPED_UNICODE),
            ]);
        } else {
            $hl->add([
                'UF_USER_ID' => $userId,
                'UF_USER_DATA' => json_encode($userData, JSON_UNESCAPED_UNICODE),
            ]);
        }
    }

    public static function updateUserFromHL($hlRow)
    {
        if (empty($hlRow['UF_USER_ID']) || empty($hlRow['UF_USER_DATA'])) {
            return false;
        }

        $userId = $hlRow['UF_USER_ID'];
        $userData = json_decode($hlRow['UF_USER_DATA'], true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return false;
        }

        $fields = [];

        foreach (self::$fieldMap as $jsonField => $userField) {
            if (isset($userData[$jsonField])) {
                $fields[$userField] = $userData[$jsonField];
            }
        }

        if (!empty($fields)) {
            $user = new \CUser;
            $user->Update($userId, $fields);
        }
    }
}
