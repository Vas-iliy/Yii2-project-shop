<?php

namespace shop\services\admin\shop;

use shop\forms\admin\shop\product\ReviewEditForm;
use shop\repositories\shop\ProductRepository;

class ReviewService
{
    private $products;

    public function __construct()
    {
        $this->products = new ProductRepository();
    }

    public function edit($id, $reviewId, ReviewEditForm $form): void
    {
        $product = $this->products->get($id);
        $product->editReview(
            $reviewId,
            $form->vote,
            $form->text
        );
        $this->products->save($product);
    }

    public function activate($id, $reviewId): void
    {
        $product = $this->products->get($id);
        $product->activateReview($reviewId);
        $this->products->save($product);
    }

    public function draft($id, $reviewId): void
    {
        $product = $this->products->get($id);
        $product->draftReview($reviewId);
        $this->products->save($product);
    }

    public function remove($id, $reviewId): void
    {
        $product = $this->products->get($id);
        $product->removeReview($reviewId);
        $this->products->save($product);
    }
}