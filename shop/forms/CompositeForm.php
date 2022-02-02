<?php

namespace forms;

use yii\base\Model;
use yii\helpers\ArrayHelper;

abstract class CompositeForm extends Model
{
    private $forms = [];

    abstract protected function internalForms();

    public function load($data, $formName = null)
    {
        $success = parent::load($data, $formName);
        foreach ($this->forms as $name => $form) {
            if (is_array($form)) {
                $success = Model::loadMultiple($form, $data, $formName === '' ? $name : null) && $success;
            }
            $success = $this->load($data,$formName === '' ? $name : null) && $success;
        }
        return $success;
    }

    public function validate($attributeNames = null, $clearErrors = true)
    {
        $success = parent::validate(array_filter($attributeNames, 'is_string'), $clearErrors);
        foreach ($this->forms as $name => $form) {
            if (is_array($form)) {
                $success = Model::validateMultiple($form) && $success;
            } else {
                $success = $form->validate(ArrayHelper::getValue($attributeNames, $name), $clearErrors) && $success;
            }
        }
        return $success;
    }

    public function __get($name)
    {
        if (isset($this->forms[$name])) {
            return $this->forms[$name];
        }
        return parent::__get($name);
    }

    public function __set($name, $value)
    {
        if (in_array($name, $this->internalForms(), true)) {
            $this->forms[$name] = $value;
        } else {
            parent::__set($name, $value);
        }
    }

    public function __isset($name)
    {
        return isset($this->forms[$name]) || parent::__isset($name);
    }
}