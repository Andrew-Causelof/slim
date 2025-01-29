<?php

namespace Seogravity\DB;

use Bitrix\Main\Loader;
use Bitrix\Highloadblock\HighloadBlockTable;

class HLBlockImporter
{
    protected $hlBlockTable;

    public function __construct($hlblockId)
    {
        $this->hlBlockTable = new HLBlockTable($hlblockId);
    }

    public function importFromJson($jsonData)
    {
        $data = json_decode($jsonData, true);
        if (!is_array($data)) {
            throw new \Exception("Некорректный JSON формат.");
        }

        $existingRecords = $this->getExistingRecords();
        $added = 0;
        $updated = 0;

        foreach ($data as $item) {
            if (!isset($item['UF_ID']) || !isset($item['UF_NAME'])) {
                continue; // Пропускаем записи без нужных полей
            }

            if (array_key_exists($item['UF_ID'], $existingRecords)) {
                $result = $this->hlBlockTable->update($existingRecords[$item['UF_ID']], [
                    'UF_NAME' => $item['UF_NAME']
                ]);
                if ($result) {
                    $updated++;
                }
            } else {
                $result = $this->hlBlockTable->add([
                    'UF_ID' => $item['UF_ID'],
                    'UF_NAME' => $item['UF_NAME']
                ]);
                if ($result === true) {
                    $added++;
                }
            }
        }

        return [
            'added' => $added,
            'updated' => $updated,
        ];
    }

    protected function getExistingRecords()
    {
        $records = $this->hlBlockTable->getList([
            'select' => ['ID', 'UF_ID']
        ]);

        $existingRecords = [];
        foreach ($records as $record) {
            $existingRecords[$record['UF_ID']] = $record['ID'];
        }

        return $existingRecords;
    }
}
