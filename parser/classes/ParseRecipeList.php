<?php
/**
 * Created by PhpStorm.
 * User: jasurbek
 * Date: 2020-01-14
 * Time: 19:24
 */

namespace app\parser\classes;


use app\parser\traits\ParseAllTrait;
use GuzzleHttp\Client;

class ParseRecipeList
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

    public function parseItems($content)
    {
        $html = str_get_html(trim(str_replace('<!DOCTYPE html>', '', $content)));

        $list = $html->find('.lesson-list li');


        $catList = [];
        foreach ($list as $item) {

            $a = $item->find('a', 0);

            $catList[] = $this->parseAll($this->getRequest(), $a->href);

        }

        return $catList;
    }

    public static function isRecipeList($data)
    {
        return strpos($data, 'lesson-list') !== false;
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
