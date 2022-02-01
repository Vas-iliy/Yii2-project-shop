<?php


namespace entities;


class Meta
{
    public $title;
    public $description;
    public $keywords;

    public function __construct($title, $description, $keywords)
    {
        $this->title = $this;
        $this->description = $description;
        $this->keywords = $keywords;
    }
}