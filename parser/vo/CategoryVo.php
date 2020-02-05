<?php
/**
 * Created by PhpStorm.
 * User: jasurbek
 * Date: 2020-01-14
 * Time: 15:57
 */

namespace app\parser\vo;


class CategoryVo
{
    public $id;
    public $link;
    public $name;
    public $curseCount;
    public $excerpt;
    public $children = [];

    public function __construct($id, $link, $name)
    {
        $this->id = $id;
        $this->link = $link;
        $this->name = $name;
    }
}
