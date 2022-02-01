<?php

/* @var $this yii\web\View */
/* @var $user \shop\entities\User */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/verification/index', 'token' => $user->verification_token]);
?>
Hello <?= $user->username ?>,

Follow the link below to verify your email:

<?= $verifyLink ?>
