<?php

namespace Api\Models;

use \Seogravity\DB\HLBlockTable;

class Data
{
    private static $hlblocks = [
        'HandbookRegions' => 1,
        'HandbookDiseases' => 2,
        'HandbookBadHabbits' => 3,
        'HandbookAlergy' => 4,
        'HandbookInfections' => 5,
        'HandbookMedications' => 6,

    ];

    public static function find($id)
    {
        $hlBlockTable = new HLBlockTable($id);

        return $hlBlockTable->getList();
    }
}
