<?php

namespace Api\Models;

use \Seogravity\DB\HLBlockTable;
use Seogravity\Application\CachedContent;

class Data
{
    private static $hlblocks = [
        'HandbookRegions'     => 1,
        'HandbookDiseases'    => 2,
        'HandbookBadHabbits'  => 3,
        'HandbookAlergy'      => 4,
        'HandbookInfections'  => 5,
        'HandbookMedications' => 6,
        'TagDescription'      => 8,

    ];

    public static function find($id)
    {
        $result = CachedContent::get($id, self::$hlblocks[$id], 3600, function () use ($id) {
            $hlBlockTable = new HLBlockTable($id);
            return $hlBlockTable->getList();
        });

        return $result;
    }

    public static function findAll()
    {
        $hlBlocks = [];

        foreach (self::$hlblocks as $key => $value) {
            $hlBlocks[$key] = self::find($value);
        }

        return $hlBlocks;
    }
}
