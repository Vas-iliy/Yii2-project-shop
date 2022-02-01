<?php

namespace backend\controllers;

use shop\forms\auth\LoginForm;
use shop\services\auth\AuthService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;

class SiteController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
}
