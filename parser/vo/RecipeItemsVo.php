<?php
/**
 * Created by PhpStorm.
 * User: jasurbek
 * Date: 2020-01-14
 * Time: 19:45
 */

namespace app\parser\vo;


class RecipeItemsVo
{
    public $title;
    public $items = [];

    public function __construct($title, $items)
    {

        $this->title = $title;
        $this->items = $items;
    }
}
