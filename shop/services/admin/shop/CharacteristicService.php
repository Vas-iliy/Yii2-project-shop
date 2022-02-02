<?php

namespace services\admin\shop;

use entities\shop\Characteristic;
use forms\admin\shop\CategoryForm;
use forms\admin\shop\CharacteristicForm;
use repositories\shop\CharacteristicRepository;

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
            $form->request,
            $form->default,
            $form->variants,
            $form->sort,
          );
        $this->characteristics->save($characteristic);
        return $characteristic;
    }

    public function edit($id, CategoryForm $form)
    {
        $characteristics = $this->characteristics->get($id);
        $characteristics->edit(
            $form->name,
            $form->type,
            $form->request,
            $form->default,
            $form->variants,
            $form->sort,
        );
        $this->characteristics->save($characteristics);
    }

    public function remove($id)
    {
        $category = $this->characteristics->get($id);
        $this->characteristics->remove($category);
    }
}