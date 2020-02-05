<?php
/**
 * Created by PhpStorm.
 * User: jasurbek
 * Date: 2020-01-16
 * Time: 01:33
 */

namespace app\PdfSaver;


use app\parser\vo\CategoryVo;
use app\parser\vo\RecipeVo;

class PdfRunner
{

    private $items;

    public function __construct($items)
    {

        $this->items = $items;
    }

    public function save()
    {
        if (!$this->items) {
            return null;
        }

        if (is_array($this->items)) {
            $model = new CategoryVo('', '', '');
            $model->children = $this->items;
            return $this->saveAny($model);
        }

        return $this->saveAny($this->items);
    }

    public function saveAny($item)
    {
        if ($item instanceof CategoryVo) {
            return $this->iretateCats($item);
        }

        if ($item instanceof RecipeVo) {
            return $this->saveRecipe($item);
        }

        if (is_array($item)) {
            $model = new CategoryVo('', '', '');
            $model->children = $item;
            return $this->saveAny($item);
        }

        return [];
    }

    public function saveRecipe(RecipeVo $recipeVo)
    {
        $saver = new PdfSaver();
        $data = $this->render([
            'recipe' => $recipeVo,
        ]);

        $saver->savePdf($data, \Yii::getAlias('@app/web/pdf/'), $recipeVo->getNameForSaving() . '.pdf');
        return $recipeVo;
    }


    public function iretateCats(CategoryVo $categoryVo)
    {
        foreach ($categoryVo->children as $child) {
            $this->saveAny($child);
        }

        return $categoryVo;
    }

    public function render($data)
    {
        return \Yii::$app->view->render('//article/pdf', $data);
    }
}
