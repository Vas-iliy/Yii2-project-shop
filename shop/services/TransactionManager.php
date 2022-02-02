<?php

namespace services;

class TransactionManager
{
    public function wrap(callable $function)
    {
        \Yii::$app->db->transaction($function);
    }
}