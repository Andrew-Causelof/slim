<?php

namespace Seogravity\User;

use Bitrix\Main\Loader;
use Bitrix\Main\UserTable;
use Seogravity\DB\HLBlockTable;
use Bitrix\Main\Type\Date;
use CFile;
use Bitrix\Highloadblock\HighloadBlockTable;

class PatientHLService
{
    protected static $hlblockId = HLBLOCK_ID_PATIENT_DATAS;


    private static $fieldMap  = [
        "activeTab" => [null, 'string'],
        "gender" => ["PERSONAL_GENDER", 'gender'],

        "birthday" => ["PERSONAL_BIRTHDAY", 'date'],
        "passportDate" => ["UF_PASSPORT_DATE", 'date'],

        "polisRegion" => ['UF_POLIS_REGION', 'hlblock'],
        "diseaseList"  => ['UF_DISEASES_LIST', 'hlblock'],
        "medicationList" => ['UF_MEDICATIONS_LIST', 'hlblock'],
        "alergyList" => ['UF_ALERGY_LIST', 'hlblock'],
        "infectionList" => ['UF_INFECTIONS_LIST', 'hlblock'],
        "badHabbitsList" => ['UF_MEDICATIONS_BADHABBITS_LIST', 'hlblock'],


        "snils" => ["UF_SNILS", 'string'],
        "firstname" => ["NAME", 'string'],
        "lastname" => ["LAST_NAME", 'string'],
        "thirdname" => ["SECOND_NAME", 'string'],
        "height" => ["UF_HEIGHT", 'string'],
        "weight" => ["UF_WEIGHT", 'string'],
        "phone" => ["PERSONAL_PHONE", 'string'],
        "phone2" => ["PERSONAL_MOBILE", 'string'],
        "email" => ["EMAIL", 'string'],
        "polis" => ["UF_POLIS", 'string'],
        "passportFrom" => ["UF_PASSPORT_BY", 'string'],
        "passport" => ["UF_PASSPORT", 'string'],
        "city" => ["PERSONAL_CITY", 'string'],
        "address" => ["UF_PASSPORT_ADDRESS", 'string'],
        "comment" => ["UF_COMMENT", 'string'],
        "surgeriesComment" => ["UF_SURGERIES_COMMENT", 'string'],
        "inheritanceDiseasesComment" => ["UF_INHERITANCE_DISEASES_COMMENT", 'string'],


        "alergy" => ["UF_ALERGY", 'bool'],
        "surgeries" => ["UF_SURGERIES", 'bool'],
        "medications" => ["UF_MEDICATIONS", 'bool'],
        "infection" => ["UF_INFECTION", 'bool'],
        "badHabbits" => ["UF_BAD_HABBITS", 'bool'],
        "pregnant" => ["UF_PREGNANT", 'bool'],
        "sickLeave" => ["UF_SICK_LEAVE", 'bool'],
        "chronicDiseases" => ["UF_CHRONIC_DISEASES", 'bool'],


        "passport_files" => ['UF_FILES_PASSPORT', 'file'],
        "polis_files" => ['UF_FILES_POLIS', 'file'],
        "snils_files" => ['UF_FILES_SNILS', 'file'],
        "general_files" => ['UF_FILES_CBC', 'file'],
        "coagulogram_files" => ['UF_COAGULOGRAM', 'file'],
        "blood-biochemical_files" => ['UF_BIOCHEMICAL', 'file'],
        "blood-infectious_files" => ['UF_INFECTIOUS', 'file'],
        "blood-group_files" => ['UF_BLOOD_GROUP', 'file'],
        "blood-phenotyping_files" => ['UF_PHENOTYPING', 'file'],
        "urine-general_files" => ['UF_URINE', 'file'],
        "covid_files" => ['UF_COVID', 'file'],
    ];

    public static function getFieldMap(): array
    {
        return self::$fieldMap;
    }

    public static function getJsonFromUser($userId): ?array
    {
        Loader::includeModule('main');

        $user = UserTable::getList([
            'filter' => ['ID' => $userId],
            'select' => ['*', 'UF_*'],
        ])->fetch();

        if (!$user) return null;

        $json = [];

        foreach (self::$fieldMap as $jsonKey => [$userField, $type]) {
            if ($userField === null) continue; // технические поля

            $value = $user[$userField] ?? null;

            switch ($type) {
                case 'bool':
                    $json[$jsonKey] = $value === '1' || $value === 1 || $value === true ? 'yes' : 'no';
                    break;
                case 'date':
                    $json[$jsonKey] = $value instanceof \Bitrix\Main\Type\Date ? $value->format('d.m.Y') : (string)$value;
                    break;
                case 'file':
                    $fileArr = is_array($value)
                        ? array_map(function ($id) {
                            $file = \CFile::GetFileArray($id);
                            return $file ? [
                                'id' => (int)$file['ID'],
                                'name' => $file['ORIGINAL_NAME'],
                                'path' => $file['SRC'],
                                'size' => (string)$file['FILE_SIZE'],
                            ] : null;
                        }, $value)
                        : [];
                    // Удалим возможные null (если какой-то файл не найден)
                    $json['files'][$jsonKey] = array_filter($fileArr);
                    break;
                case 'hlblock':
                    if (is_array($value)) {
                        $items = [];
                        foreach ($value as $hlId) {
                            $hlItem = self::getHLBlockItem($jsonKey, $hlId);
                            if ($hlItem) {
                                $items[] = [
                                    'id' => (string)$hlItem['ID'],
                                    'name' => $hlItem['UF_NAME'],
                                ];
                            }
                        }
                        $json[$jsonKey] = $items;
                    } else {
                        $hlItem = self::getHLBlockItem($jsonKey, $value);

                        if ($hlItem) {
                            $json[$jsonKey] = [
                                'id' => (string)$hlItem['ID'],
                                'name' => $hlItem['UF_NAME'],
                            ];
                        }
                    }
                    break;

                default:
                    $json[$jsonKey] = $value;
            }
        }

        //Исключния

        if (isset($json['gender'])) {
            $json['gender'] =   ($json['gender']  == 'F') ? 'fem' : 'male';
        }

        return $json;
    }


    private static function getHLBlockItem($jsonKey, $id)
    {
        // Сопоставление JSON ключа с ID хайлоадблока
        $hlMap = [
            'diseaseList'       => HLBLOCK_ID_HANDBOOK_DISEASES,
            'medicationList'    => HLBLOCK_ID_HANDBOOK_MEDICATIONS,
            'alergyList'        => HLBLOCK_ID_HANDBOOK_ALERGY,
            'infectionList'     => HLBLOCK_ID_HANDBOOK_INFECTIONS,
            'badHabbitsList'    => HLBLOCK_ID_HANDBOOK_HABBITS,
            'polisRegion'       => HLBLOCK_ID_HANDBOOK_REGIONS,
        ];

        if (!isset($hlMap[$jsonKey]) || !$id) {
            return null;
        }

        Loader::includeModule('highloadblock');

        $hlBlock = HighloadBlockTable::getById($hlMap[$jsonKey])->fetch();

        if (!$hlBlock) {
            return null;
        }

        $entity = HighloadBlockTable::compileEntity($hlBlock);
        $entityClass = $entity->getDataClass();

        $row = $entityClass::getRow([
            'filter' => ['ID' => $id],
            'select' => ['ID', 'UF_NAME']
        ]);

        return $row;
    }


    /**
     * Обновляет в $json только те поля, что описаны в $map
     */
    public static function updateJsonFields(array $json, array $updates, array $map): array
    {
        // Обработка вложенного блока файлов отдельно
        if (isset($updates['files']) && is_array($updates['files'])) {
            if (!isset($json['files']) || !is_array($json['files'])) {
                $json['files'] = [];
            }

            foreach ($updates['files'] as $fileKey => $fileValue) {
                $json['files'][$fileKey] = $fileValue;
            }
        }

        // Обработка остальных полей на основании маппинга
        foreach ($map as $jsonKey => $userField) {
            // Пропускаем "files", потому что оно уже обработано выше
            if ($jsonKey === 'files') {
                continue;
            }

            if (!array_key_exists($jsonKey, $updates)) {
                continue;
            }

            $json[$jsonKey] = $updates[$jsonKey];
        }

        return $json;
    }


    /**
     * Обновляем данные в HL-блоке на основании пользовательских полей
     */
    public static function updateHLFromUser($userId)
    {
        Loader::includeModule('highloadblock');
        Loader::includeModule('main');

        $user = UserTable::getById($userId)->fetch();

        if (!$user) {
            return false;
        }

        // Формируем JSON из пользовательских полей
        $newUserData = self::getJsonFromUser($userId);

        $hl = new HLBlockTable(self::$hlblockId);

        $existing = $hl->getList([
            'filter' => ['UF_USER_ID' => $userId],
            'limit' => 1,
        ]);

        if (!empty($existing[0])) {

            $currentUserData = json_decode($existing[0]["UF_USER_DATA"], true);
            $mergedUserData = self::updateJsonFields($currentUserData, $newUserData, self::$fieldMap);

            $mergedUserData['progress'] = self::calculateProgress($mergedUserData); //обновление прогресса

            $hl->update($existing[0]['ID'], [
                'UF_USER_DATA' => json_encode($mergedUserData, JSON_UNESCAPED_UNICODE),
            ]);
        } else {
            //@TODO - добавить технические поля, активной таблицы, процессов если необходимо
            $newUserData['progress'] = self::calculateProgress($newUserData);

            $hl->add([
                'UF_USER_ID' => $userId,
                'UF_USER_DATA' => json_encode($newUserData, JSON_UNESCAPED_UNICODE),
            ]);
        }

        return true;
    }

    //Расчет прогресса, копия метода с фронта на стороне пациента
    public static function calculateProgress(array $json): array
    {
        $sections = [
            'general' => [
                'gender',
                'lastname',
                'firstname',
                'thirdname',
                'birthday',
                'height',
                'weight',
                'phone',
                'phone2',
                'email',
                'polis',
                'polisRegion',
                'snils',
                'passport',
                'passportDate',
                'passportFrom',
                'city',
                'address',
            ],
            'medical' => [
                'comment',
                'chronicDiseases',
                'diseaseList',
                'medications',
                'medicationList',
                'surgeries',
                'surgeriesComment',
                'alergy',
                'alergyList',
                'infection',
                'infectionList',
                'inheritanceDiseasesComment',
                'badHabbits',
                'badHabbitsList',
                'pregnant',
                'sickLeave',
            ],
            'documents' => [
                'passport_files',
                'polis_files',
                'snils_files',
                'general_files',
                'coagulogram_files',
                'blood-biochemical_files',
                'blood-infectious_files',
                'blood-group_files',
                'blood-phenotyping_files',
                'urine-general_files',
                'covid_files',
            ],
        ];

        $progress = [];

        foreach ($sections as $section => $fields) {
            $filledCount = 0;

            foreach ($fields as $field) {
                $value = ($section === 'documents' && isset($json['files'][$field])) ? $json['files'][$field] : ($json[$field] ?? null);
                if (is_array($value) && count($value) > 0) {
                    $filledCount++;
                } elseif (is_string($value) && $value !== '') {
                    $filledCount++;
                }
                //  elseif ($value !== NULL && $value !== '' && !is_array($value)) {
                //     $filledCount++;
                // }
            }

            $progress[$section] = round(($filledCount / count($fields)) * 100);
        }

        return $progress;
    }


    /**
     * Обновляем пользовательские поля из HL-блока
     */
    public static function updateUserFromHL(array $hlRow)
    {
        if (empty($hlRow['UF_USER_ID']) || empty($hlRow['UF_USER_DATA'])) {
            return false;
        }

        $userId = (int) $hlRow['UF_USER_ID'];
        $jsonData = json_decode($hlRow['UF_USER_DATA'], true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($jsonData)) {
            return false;
        }

        $user = \Bitrix\Main\UserTable::getById($userId)->fetch();
        if (!$user) {
            return false;
        }

        $fieldsToUpdate = [];

        foreach (self::$fieldMap as $jsonKey => $userField) {
            if (!array_key_exists($jsonKey, $jsonData)) {
                continue;
            }

            [$UF_CODE, $UF_TYPE] = (array) $userField;
            $value = $jsonData[$jsonKey];


            switch ($UF_TYPE) {
                case 'hlblock':
                    if (isset($value['id'])) {
                        $fieldsToUpdate[$UF_CODE] = [$value['id']];
                    } elseif (is_array($value)) {
                        $fieldsToUpdate[$UF_CODE] = array_filter(array_column($value, 'id'));
                    }
                    break;

                case 'bool':
                    $fieldsToUpdate[$UF_CODE] = $value === 'yes' ? 1 : 0;
                    break;

                case 'date':
                    $fieldsToUpdate[$UF_CODE] = \Bitrix\Main\Type\Date::createFromText($value);
                    break;

                case 'string':
                default:
                    $fieldsToUpdate[$UF_CODE] = (string) $value;
                    break;
            }
        }

        //  Обработка блока `files`
        if (!empty($jsonData['files']) && is_array($jsonData['files'])) {
            foreach ($jsonData['files'] as $jsonFileKey => $fileList) {
                $field = self::$fieldMap[$jsonFileKey] ?? null;
                $UF_CODE = is_array($field) ? $field[0] : $field;

                if (!$UF_CODE || !is_array($fileList)) {
                    continue;
                }

                // Преобразуем каждый ID в корректную структуру файла
                $files = array_filter(array_map(function ($file) {
                    if (isset($file['id'])) {
                        return \CFile::MakeFileArray($file['id']);
                    }
                    return null;
                }, $fileList));

                if (!empty($files)) {
                    $fieldsToUpdate[$UF_CODE] = $files;
                }
            }
        }


        //  Обработка пола
        if (!empty($jsonData['gender'])) {
            $fieldsToUpdate['PERSONAL_GENDER'] = $jsonData['gender'] === 'fem' ? 'F' : 'M';
        }


        if (empty($fieldsToUpdate)) {
            return false; // Нет данных для обновления
        }



        $userObj = new \CUser;
        $result = $userObj->Update($userId, $fieldsToUpdate);

        // if (!$result) {
        //     echo '<pre>';
        //     echo "Ошибка обновления пользователя: " . $userObj->LAST_ERROR;
        //     echo '</pre>';
        //     return false;
        // }

        return  $result;

        // return true;
    }
}
