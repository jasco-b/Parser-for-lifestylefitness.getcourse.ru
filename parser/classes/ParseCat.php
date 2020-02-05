<?php

namespace app\parser\classes;

use app\parser\traits\ParseAllTrait;
use app\parser\vo\CategoryVo;
use GuzzleHttp\Client;

/**
 * Created by PhpStorm.
 * User: jasurbek
 * Date: 2020-01-11
 * Time: 13:16
 */
class ParseCat
{
    use ParseAllTrait;

    private $link;
    private $request;

    public function __construct(Client $client, $link = null)
    {

        $this->link = $link;
        $this->request = $client;
    }

    public function parse()
    {
        $res = $this->getRequest()->get($this->link);
        $content = $res->getBody()->getContents();

        return $this->parseItems($content);
    }

    protected function parseItems($content)
    {
        $html = str_get_html(trim(str_replace('<!DOCTYPE html>', '', $content)));

        $rootHtml = $html->find('.xdget-trainingList', 0);

        if (!$rootHtml) {
            return [];
        }

        $catTraningList = $rootHtml->find('tr');
        $catList = [];
        foreach ($catTraningList as $catTraining) {

            $catVo = $this->generateCatObject($catTraining);
            $children = $this->parseAll($this->getRequest(), $catVo->link);
            if ($children){
                $catVo->children = $children;
            }
            $catList[] = $catVo;

        }

        return $catList;
    }

    protected function generateCatObject($catTraining)
    {
        $attrs = $catTraining->attr;
        $id = null;
        //id
        if (isset($attrs['data-training-id'])) {
            $id = $attrs['data-training-id'];
        }

        // link
        $a = $catTraining->find('a', 0);


        $link = $a->href;

        // title
        $title = $a->find('.stream-title', 0)->innertext;

        $otherInfo = $a->find('div', 0)->innertext;

        $catVo = new CategoryVo($id, $link, $title);
        $catVo->excerpt = $otherInfo;
        return $catVo;
    }

    public static function isCategory($data)
    {
        return strpos($data, 'xdget-trainingList') !== false;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public static function parseFromContent($content, Client $client)
    {
        $parser = new self ($client);
        return $parser->parseItems($content);
    }
}
