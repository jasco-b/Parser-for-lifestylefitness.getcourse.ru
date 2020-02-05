<?php
/**
 * Created by PhpStorm.
 * User: jasurbek
 * Date: 2020-01-16
 * Time: 00:47
 *
 * @var \app\parser\vo\RecipeVo $recipe
 * @var $this \yii\web\View
 */
?>


<div class="title" align="center" style="font-size: 30px; text-align: center; font-weight: 800">
    <?= $recipe->title ?>
</div>

<div class="link" style="text-align: center; font-size: 12px"><?= $recipe->link ?></div>

<br/>
<?php foreach ($recipe->items as $item): ?>
    <?= $this->render('item', [
        'item' => $item,
    ]) ?>
<?php endforeach; ?>

<div class="img" align="center" style="width: 500px" >
    <img src="https:<?= $recipe->img  ?>" alt="img">
</div>
