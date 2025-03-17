<?php

// global $SiteExpireDate;
// if ($SiteExpireDate < time()) {
//     $SiteExpireDate = time() * 1.1;
// }

if (file_exists(__DIR__ . '/const.php')) {
    /** Подключение файла глобальных констант */
    require_once __DIR__ . '/const.php';
}

require_once dirname(__DIR__) . '/vendor/autoload.php';

if (file_exists(__DIR__ . '/events.php')) {
    /** Подключение файла событий */
    require_once __DIR__ . '/events.php';
}

if (file_exists(__DIR__ . '/handlers.php')) {
    /** Подключение файла событий */
    require_once __DIR__ . '/handlers.php';
}
