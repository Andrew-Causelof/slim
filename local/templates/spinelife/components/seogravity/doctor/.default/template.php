<?php

use Seogravity\User\User;

global $USER;

$user = new User($USER->GetID());

if (!$user->isDoctor()) {
    LocalRedirect('/');
    exit;
}
$templateFolder = $this->GetFolder();
?>

<script>
    window.__DOCTOR__ = {
        id: <?= (int)$USER->GetID(); ?>
    };
</script>
<div id="react-lk-patient"></div>

<script src="<?= $templateFolder ?>/vite/dist/bundle.js"></script>