<?php

use Bitrix\Main\Engine\Response\Redirect;
use Seogravity\User\User;

$user = new User($USER->GetID());
$user->redirectIfAuthorized();

?>
<?php $templateFolder = $this->GetFolder(); ?>

<div id="react-auth"></div>

<script src="<?= $templateFolder ?>/js/dist/bundle.js"></script>