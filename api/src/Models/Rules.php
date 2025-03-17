<?php

namespace Api\Models;

use Bitrix\Main\Loader;

class Rules
{
    private int $iblockId;
    private int $elementId;

    public function __construct(int $iblockId, int $elementId)
    {
        $this->iblockId = $iblockId;
        $this->elementId = $elementId;
        Loader::includeModule('iblock');
    }

    public function getRules(): array
    {
        $settings = $this->getAlldatas($this->iblockId, $this->elementId);

        $result = [
            'RULES_TITLE' => $settings['RULES_TITLE']["VALUE"],
            'GENERAL_REQUIREMENTS' => $settings['GENERAL_REQUIREMENTS']["VALUE"],
            'PROCEDURE' => $settings['PROCEDURE']["VALUE"],
            'ADDITIONAL_RECOMMENDATIONS' => $settings['ADDITIONAL_RECOMMENDATIONS']["VALUE"],
            'HOSPITALIZATION' => $settings['HOSPITALIZATION']["VALUE"],
        ];

        return $result;
    }

    /**
     * Возвращает массив элементов инфоблока, включая свойства 
     * @param int|string $iblock
     * @param int|string $elementId
     * @return array|false
     */
    public function getAlldatas(int|string $iblock, int|string $elementId): array | false
    {
        if (empty($iblock) || empty($elementId)) {
            return false;
        }

        Loader::includeModule('iblock');

        $datas = [];

        $arFilter = [
            "IBLOCK_ID" => $iblock,
            "ID" => $elementId,
            "ACTIVE" => "Y"
        ];

        $res = \CIBlockElement::GetList([], $arFilter, false, false, []);

        if ($ob = $res->GetNextElement()) {
            $arFields = $ob->GetFields();
            $arProperties = $ob->GetProperties();

            $datas = [
                "ID" => $arFields["ID"],
                "NAME" => $arFields["NAME"],
                "PREVIEW_TEXT" => $arFields["PREVIEW_TEXT"],
                "PREVIEW_PICTURE" => $arFields["PREVIEW_PICTURE"],
                "DETAIL_TEXT" => $arFields["DETAIL_TEXT"],
                "DETAIL_PICTURE" => $arFields["DETAIL_PICTURE"],
                "ACTIVE_FROM" => $arFields["ACTIVE_FROM"],
                "DETAIL_PAGE_URL" => $arFields["DETAIL_PAGE_URL"],
                'IBLOCK_SECTION_ID' => $arFields['IBLOCK_SECTION_ID']
            ];

            foreach ($arProperties as $property) {
                $datas[$property["CODE"]] = $property;
            }
        }

        return $datas;
    }
}
