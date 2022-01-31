<?php

namespace frontend\services\contact;

use frontend\forms\ContactForm;
use Yii;

class ContactService
{
    public function send(ContactForm $form)
    {
        $send = Yii::$app->mailer->compose()
            ->setTo(Yii::$app->params['adminEmail'])
            ->setReplyTo([$form->email => $form->name])
            ->setSubject($form->subject)
            ->setTextBody($form->body)
            ->send();
        if (!$send) throw new \RuntimeException('Sending error.');
    }
}