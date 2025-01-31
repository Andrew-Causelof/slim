<?php

namespace Api\Models;

use \Seogravity\DB\HLBlockTable;

class Patient
{
    protected static $patientHLBID = 7;

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

    public static function update($id, $fields)
    {
        // $hlBlockTable = new HLBlockTable(self::$patientHLBID);

        // return $hlBlockTable->update($id, $fields);
        return true;
    }
}
