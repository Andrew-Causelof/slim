<?php

// Запрещаем удаление элементов инфоблока настроек
AddEventHandler("iblock", "OnBeforeIBlockElementDelete", "PreventElementDeletion");

function PreventElementDeletion($ELEMENT_ID)
{
    if (!$ELEMENT_ID) {
        return;
    }

    // Получаем инфоблок элемента
    $res = CIBlockElement::GetByID($ELEMENT_ID);
    if ($arElement = $res->Fetch()) {
        if ($arElement["IBLOCK_ID"] == IBLOCK_ID_SETTINGS) {
            global $APPLICATION;
            $APPLICATION->ThrowException("Удаление элементов этого инфоблока запрещено.");
            return false;
        }
    }
}
