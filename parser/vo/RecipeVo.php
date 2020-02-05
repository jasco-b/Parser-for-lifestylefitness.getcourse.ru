<?php
/**
 * Created by PhpStorm.
 * User: jasurbek
 * Date: 2020-01-14
 * Time: 15:59
 */

namespace app\parser\vo;


class RecipeVo
{
    public $id;

    public $title;

    public $img;

    public $link;

    public $items;


    public function __construct($title, $link, $items, $img)
    {

        $this->title = $title;
        $this->link = $link;
        $this->items = $items;
        $this->img = $img;
    }

    public function getNameForSaving()
    {
        return str_replace(' ', '_', $this->title);
    }
}
