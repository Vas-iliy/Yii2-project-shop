<?php

namespace frontend\controllers;

use shop\services\auth\LoginService;
use shop\forms\auth\ResendVerificationEmailForm;
use shop\services\auth\PasswordResetService;
use shop\services\auth\ResendVerificationEmailService;
use shop\services\auth\AuthService;
use shop\services\auth\VerifyEmailService;
use shop\services\ContactService;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use shop\forms\auth\LoginForm;
use shop\forms\auth\PasswordResetRequestForm;
use shop\forms\auth\ResetPasswordForm;
use shop\forms\auth\SignupForm;
use shop\forms\ContactForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $this->layout = 'home';
        return $this->render('index');
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionResendVerificationEmail()
    {
        $form = new ResendVerificationEmailForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                (new ResendVerificationEmailService())->sendEmail($form);
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            } catch (\DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }


        return $this->render('resendVerificationEmail', [
            'model' => $form
        ]);
    }
}
