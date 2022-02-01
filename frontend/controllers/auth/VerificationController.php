<?php


namespace frontend\controllers\auth;


use shop\forms\auth\ResendVerificationEmailForm;
use shop\services\auth\AuthService;
use shop\services\auth\ResendVerificationEmailService;
use shop\services\auth\VerifyEmailService;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;

class VerificationController extends \yii\web\Controller
{
    private $verify;
    private $resend;

    public function __construct($id, $module, VerifyEmailService $verify, ResendVerificationEmailService $resend, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->verify = $verify;
        $this->resend = $resend;
    }

    public function actionIndex($token)
    {
        try {
            if (($user = $this->verify->verifyEmail($token)) && Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->goHome();
            }
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    public function actionResendEmail()
    {
        $form = new ResendVerificationEmailForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->resend->sendEmail($form);
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            } catch (\DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('resendEmail', [
            'model' => $form
        ]);
    }
}