<?php

namespace shop\services\admin\shop;

use shop\entities\shop\Characteristic;
use shop\forms\admin\shop\CategoryForm;
use shop\forms\admin\shop\CharacteristicForm;
use shop\repositories\shop\CharacteristicRepository;

class CharacteristicService
{
    private $characteristics;

    public function __construct()
    {
        $this->characteristics = new CharacteristicRepository();
    }

    public function create(CharacteristicForm $form)
    {
        $characteristic = Characteristic::create(
            $form->name,
            $form->type,
            $form->required,
            $form->default,
            $form->variants,
            $form->sort
          );
        $this->characteristics->save($characteristic);
        return $characteristic;
    }

    public function edit($id, CharacteristicForm $form)
    {
        $characteristics = $this->characteristics->get($id);
        $characteristics->edit(
            $form->name,
            $form->type,
            $form->required,
            $form->default,
            $form->variants,
            $form->sort
        );
        $this->characteristics->save($characteristics);
    }

    public function remove($id)
    {
        $category = $this->characteristics->get($id);
        $this->characteristics->remove($category);
    }
}