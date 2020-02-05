<?php
/**
 * Created by PhpStorm.
 * User: jasurbek
 * Date: 2020-01-16
 * Time: 00:26
 */

namespace app\PdfSaver;


use Mpdf\Output\Destination;
use yii\helpers\BaseFileHelper;

class PdfSaver
{

    protected $mpdf;

    public function __construct()
    {
        $mpdf = new \Mpdf\Mpdf();
        $this->mpdf = $mpdf;
    }

    public function savePdf($data, $path = '', $name = 'file.pdf')
    {

        BaseFileHelper::createDirectory($path);

        $this->mpdf->WriteHTML($data);
        $this->mpdf->showImageErrors =true;

        $this->mpdf->Output($path . $name, Destination::FILE);
    }
}
