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
                foreach ($form as $itemName => $itemForm) {
                    $success = $this->loadInternal($data, $itemForm, $formName, $itemName) && $success;
                }
            }
            $success = $this->loadInternal($data, $form, $formName, $name) && $success;
        }
        return $success;
    }

    private function loadInternal($data, Model $form, $formName, $name)
    {
        return $form->load($data,$formName === '' ? $name : null);
    }

    public function validate($attributeNames = null, $clearErrors = true)
    {
        $success = parent::validate(array_filter($attributeNames, 'is_string'), $clearErrors);
        foreach ($this->forms as $name => $form) {
            if (is_array($form)) {
                foreach ($form as $itemName => $itemForm) {
                    $success = $form->validate(ArrayHelper::getValue($attributeNames, $itemName), $clearErrors) && $success;
                }
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