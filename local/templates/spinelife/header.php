<?php

use Bitrix\Main\Localization\Loc;
use Seogravity\Application\App;

global $APPLICATION;

Loc::loadMessages(__FILE__);
?>
<!DOCTYPE html>
<html lang="<?= LANGUAGE_ID ?>" class="page-<?php $APPLICATION->ShowProperty('page-class'); ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <link
        rel="preconnect"
        href="https://fonts.googleapis.com" />
    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet" />
    <title><?php $APPLICATION->showTitle() ?></title>
    <?php $APPLICATION->showHead(); ?>

    <?php
    $asset = APP::asset();

    foreach (
        [
            TEMPLATE_PATH . '/assets/css/custom.css',
            TEMPLATE_PATH . '/assets/css/style.css',
        ] as $css
    ) {
        $asset->addCss($css);
    }
    foreach (
        [
            TEMPLATE_PATH . '/assets/js/script.js',
        ] as $js
    ) {
        $asset->addJs($js);
    }

    ?>
</head>

<?php $APPLICATION->showPanel() ?>

<body class="body <?= $APPLICATION->ShowProperty('page-class'); ?>">