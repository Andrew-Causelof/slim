<?php

namespace Seogravity\Application;

use Bitrix\Main\Page\Asset;
use Seogravity\Application\Helper;
use Bitrix\Main\Application;

class App
{

    /** Подключает .js и .css 
     * @param null $resources
     * 
     * @return Asset
     */
    public static function asset($resources = null): Asset
    {
        $assetManager = Asset::getInstance();

        if (!empty($resources)) {
            if (!is_array($resources)) {
                $resources = array($resources);
            }
            foreach ($resources as $resource) {
                if (Helper::endsWith($resource, '.css')) {
                    $assetManager->addCss($resource);
                } elseif (Helper::endsWith($resource, '.js')) {
                    $assetManager->addJs($resource);
                } else {
                    $assetManager->addString($resource);
                }
            }
        }
        return $assetManager;
    }

    public static function isMainPage(): bool
    {
        return $GLOBALS['APPLICATION']->GetCurPage(false) == '/';
    }


    /** Возвращает текущий урл сайта
     * @return string
     */
    public static function getSiteUrl(): string
    {
        global $APPLICATION;

        $protocol = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? "https://" : "http://";
        return $protocol . $_SERVER["SERVER_NAME"];
    }

    public static function editSection($iblockId, $sectionId): string
    {

        global $USER;

        $output = '';

        if ($USER->IsAdmin()) {

            $output .= '<div class="wrapper">';
            $output .= '<a href="/bitrix/admin/iblock_section_edit.php?IBLOCK_ID=' . $iblockId . '&type=sections&ID=' . $sectionId . '" target="_blank">Редактировать секцию</a>';
            $output .= '</div>';
        }

        return $output;
    }

    public static function editElement($iblockId, $elementId): string
    {
        global $USER;
        $output = '';

        if ($USER->IsAdmin()) {
            $output .= '<div class="wrapper editElement">';
            $output .= '<a href="/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=' . $iblockId . '&type=content&ID=' . $elementId . '" target="_blank" class="bitrix-edit-link">Редактировать элемент</a>';
            $output .= '</div>';
        }

        return $output;
    }

    public static function editElementByCode($iblockId, $elementCode): string
    {
        $arFilter = array(
            'IBLOCK_ID' => $iblockId,
            'CODE' => $elementCode
        );
        $res = \CIBlockElement::GetList(array(), $arFilter, false, array('nTopCount' => 1), array('ID'));
        if ($arItem = $res->Fetch()) {
            $elementId = $arItem['ID'];
            return self::editElement($iblockId, $elementId);
        }

        return '';
    }

    public static function setCanonicl(): string
    {

        $request = Application::getInstance()->getContext()->getRequest();
        $url = $request->getRequestUri();
        $parsed_url = parse_url($url);
        // Если есть строка запроса, проверим наличие 'PAGEN_'
        if (isset($parsed_url['query']) && strpos($parsed_url['query'], 'PAGEN_') !== false) {

            $baseUrl = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . $parsed_url['path'];

            return '<link rel="canonical" href="' . $baseUrl . '"/>';
        }

        return '';
    }
}
