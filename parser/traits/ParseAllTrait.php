<?php
/**
 * Created by PhpStorm.
 * User: jasurbek
 * Date: 2020-01-14
 * Time: 17:19
 */

namespace app\parser\traits;


use app\parser\classes\ParseAll;
use GuzzleHttp\Client;

trait ParseAllTrait
{
    public function parseAll(Client $client, $link)
    {
        $parser = new ParseAll($client, $link);
        return $parser->parse();
    }


    public function parseAllFromContent($content, Client $client)
    {
        return ParseAll::parseFromContent($content, $client);
    }
}
