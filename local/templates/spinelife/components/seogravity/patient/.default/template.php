<?php

use Seogravity\User\User;

global $USER;

$user = new User($USER->GetID());

if (!$user->isPatient()) {
    LocalRedirect('/');
    exit;
}
$templateFolder = $this->GetFolder();
?>

<script>
    window.__USER__ = {
        tableID: <?= (int)$user->getTableID(); ?>,
        userID: <?= (int)$USER->GetID(); ?>
    };
</script>
<div id="react-lk-patient"></div>

<script src="<?= $templateFolder ?>/vite/dist/bundle.js"></script>