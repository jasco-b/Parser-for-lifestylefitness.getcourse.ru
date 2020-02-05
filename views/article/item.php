<?php
/**
 * Created by PhpStorm.
 * User: jasurbek
 * Date: 2020-01-16
 * Time: 00:50
 * @var $item \app\parser\vo\RecipeItemsVo;
 */
?>
<br/>

<div class="items">
    <div class="subtitle" style="font-size: 20px; font-weight: 600; padding-left: 20px">
        <?= $item->title ?>
    </div>

    <?php foreach ($item->items as $subItem): ?>
        <div class="sub-item" style="padding-left: 30px;">
            <?= $subItem ?>
        </div>
    <?php endforeach; ?>
</div>
