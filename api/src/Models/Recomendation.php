<?php

namespace Api\Models;

use Bitrix\Main\Loader;

class Recomendation
{
    private int $iblockId;
    private int $elementId;

    public function __construct(int $iblockId, int $elementId)
    {
        $this->iblockId = $iblockId;
        $this->elementId = $elementId;
        Loader::includeModule('iblock');
    }

    public function getRecomendation(): array
    {
        $settings = $this->getAlldatas($this->iblockId, $this->elementId);

        $videos = [];
        if (!empty($settings['RECOMMENDATION_VIDEO']["VALUE"])) {
            foreach ($settings['RECOMMENDATION_VIDEO']["VALUE"] as $video) {
                $videos[] = $this->getAlldatas(IBLOCK_ID_VIDEO, $video);
            }
        }

        $result = [
            'RECOMMENDATION_TITLE' => $settings['RECOMMENDATION_TITLE']["VALUE"],
            'RECOMMENDATION_VIDEO_TITLE' => $settings['RECOMMENDATION_VIDEO_TITLE']["VALUE"],
            'RECOMMENDATION_VIDEO' => $videos,
            'RECOMMENDATION_TEXT_TITLE' => $settings['RECOMMENDATION_TEXT_TITLE']["VALUE"],
            'RECOMMENDATION_TEXT' => $settings['RECOMMENDATION_TEXT']["VALUE"],

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
