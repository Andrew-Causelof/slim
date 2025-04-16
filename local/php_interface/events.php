<?php

use  Seogravity\User\PatientHLService;
use Seogravity\DB\HLBlockTable;
use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\Loader;
use Bitrix\Main\EventManager;


// Обновляем данные в HL-блоке при обновлении пользователя
EventManager::getInstance()->addEventHandler('main', 'OnAfterUserUpdate', function ($arFields) {
    if (isset($arFields['ID'])) {
        (new PatientHLService())->updateHLFromUser($arFields['ID']);
    }
});

//Обновляем данные в пользователе при обновлении HL-блока
// EventManager::getInstance()->addEventHandler('highloadblock', 'OnAfterUpdate', function (\Bitrix\Main\Event $event) {
//     $parameters = $event->getParameters();

//     if (!empty($parameters['ID'])) {
//         Loader::includeModule('highloadblock');

//         // Подключаем HL-блок ID 7
//         $hlData = HighloadBlockTable::getById(7)->fetch();
//         $entity = HighloadBlockTable::compileEntity($hlData);
//         $entityClass = $entity->getDataClass();

//         $row = $entityClass::getRow([
//             'filter' => ['ID' => $parameters['ID']]
//         ]);

//         if ($row) {
//             UserData::updateUserFromHL($row);
//         }
//     }
// });
