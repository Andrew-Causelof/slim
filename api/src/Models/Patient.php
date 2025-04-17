<?php

namespace Api\Models;

use \Seogravity\DB\HLBlockTable;
use \Seogravity\User\PatientHLService;

class Patient
{
    protected static $patientHLBID = HLBLOCK_ID_PATIENT_DATAS;

    public function __construct($id, $name, $age, $email) {}

    public static function find($id)
    {
        $hlBlockTable = new HLBlockTable(self::$patientHLBID);

        $result = $hlBlockTable->getList([
            'filter' => ['UF_USER_ID' => $id],
            'select' => ['ID', 'UF_USER_ID', 'UF_USER_DATA'], // Указываем нужные поля
            'limit' => 1
        ]);

        return !empty($result) ? $result[0] : null;
    }

    public static function update($id, $userData)
    {
        $hlBlockTable = new HLBlockTable(self::$patientHLBID);

        $encodedData = is_array($userData) ? json_encode($userData, JSON_UNESCAPED_UNICODE) : $userData;

        $result = $hlBlockTable->update($id, [
            'UF_USER_DATA' => $encodedData
        ]);

        return $result;
    }


    // public static function updateUserFields($userID)
    // {

    //     $patient = self::find($userID);

    //     if (!$patient) {
    //         return false;
    //     }

    //     $userData = json_decode($patient['UF_USER_DATA'], true);

    //     if (json_last_error() !== JSON_ERROR_NONE) {
    //         return false;
    //     }

    //     return null;
    // }

}
