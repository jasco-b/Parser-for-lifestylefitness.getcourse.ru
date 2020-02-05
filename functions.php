<?php
/**
 * Created by PhpStorm.
 * User: jasurbek
 * Date: 2020-01-17
 * Time: 10:43
 */

function param($key, $default = null)
{
    return \yii\helpers\ArrayHelper::getValue(Yii::$app->params, $key, $default);
}
