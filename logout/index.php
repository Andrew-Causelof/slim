<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php"); ?>

<?php

global $USER;

echo '<pre>';
var_dump($USER->IsAuthorized());
echo '</pre>';
if ($USER->IsAuthorized()) {
    $USER->Logout();
}


LocalRedirect('/');

?>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>