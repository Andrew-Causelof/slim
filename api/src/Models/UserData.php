<?php

namespace Api\Models;

class UserData
{
    private static $fields = [
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

    public static function getUserFieldName(string $dataName): ?string
    {
        return self::$fields[$dataName] ?? null;
    }

    public static function getDataFieldName(string $userFieldName): ?string
    {
        return array_search($userFieldName, self::$fields);
    }

    public static function getUserFileName(string $dataName): ?string
    {
        return self::$files[$dataName] ?? null;
    }

    public static function getDataFileName(string $userFieldName): ?string
    {
        return array_search($userFieldName, self::$files);
    }
}
