<?php
/**
 * Created by PhpStorm.
 * User: jasurbek
 * Date: 2020-01-17
 * Time: 10:32
 */

namespace app\commands;


use app\parser\Parser;
use app\parser\vo\LoginVo;
use app\PdfSaver\PdfRunner;
use yii\console\Controller;
use yii\helpers\ArrayHelper;

class ParserController extends Controller
{
    public function actionIndex()
    {
        $login =  $this->param('parser.login');
        $password =  $this->param('parser.password');

        $loginVo = new LoginVo($login, $password);

        $parser = new Parser($loginVo, self::url());
        $items = $parser->parse();

        $pdfSaveRunner = new PdfRunner($items);

        $pdfSaveRunner->save();
    }

    public static function url()
    {
        return 'https://lifestylefitness.getcourse.ru/teach/control/stream/view/id/128748431';
        //  'https://lifestylefitness.getcourse.ru/teach/control/stream/view/id/128748410';
    }

    public function param($key, $default = null)
    {
        return ArrayHelper::getValue(\Yii::$app->params, $key, $default);
    }
}
