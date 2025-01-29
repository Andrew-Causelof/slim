<?php

use Bitrix\Main\Localization\Loc;


global $APPLICATION;

Loc::loadMessages(__FILE__);
?>
<!DOCTYPE html>
<html lang="<?= LANGUAGE_ID ?>" class="page-<?php $APPLICATION->ShowProperty('page-class'); ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <title><?php $APPLICATION->showTitle() ?></title>
    <?php $APPLICATION->showHead(); ?>
</head>

<?php $APPLICATION->showPanel() ?>

<body class="<?= $APPLICATION->ShowProperty('page-class'); ?>">


    <header class="header">



    </header>