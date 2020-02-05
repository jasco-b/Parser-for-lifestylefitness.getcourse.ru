<?php
/**
 * Created by PhpStorm.
 * User: jasurbek
 * Date: 2020-01-14
 * Time: 17:09
 */

namespace app\parser\classes;


use GuzzleHttp\Client;

class ParseAll
{
    /**
     * @var Client
     */
    private $client;
    private $link;

    public function __construct(Client $client, $link = false)
    {

        $this->client = $client;
        $this->link = $link;
    }

    public function parse()
    {
        $res = $this->client->get($this->link);

        return $this->parseItems($res->getBody()->getContents());
    }

    protected function parseItems($content)
    {
        if (ParseCat::isCategory($content)) {
            return ParseCat::parseFromContent($content, $this->client);
        }

        if (ParseRecipeList::isRecipeList($content)) {
            return ParseRecipeList::parseFromContent($content, $this->client);
        }

        if (ParseRecipe::isRecipe($content)) {
            return ParseRecipe::parseFromContent($content, $this->client, $this->link);
        }

        return false;
    }

    public static function parseFromContent($content, Client $client)
    {
        $parser = new self ($client);
        return $parser->parseItems($content);
    }
}
