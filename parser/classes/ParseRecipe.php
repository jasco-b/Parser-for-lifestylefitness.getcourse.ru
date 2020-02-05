<?php

namespace app\parser\classes;

use app\parser\Parser;
use app\parser\vo\RecipeItemsVo;
use app\parser\vo\RecipeVo;
use GuzzleHttp\Client;

/**
 * Created by PhpStorm.
 * User: jasurbek
 * Date: 2020-01-11
 * Time: 13:17
 */
class ParseRecipe
{

    /**
     * @var Client
     */
    private $client;
    /**
     * @var null
     */
    private $link;

    public function __construct(Client $client, $link = null)
    {
        $this->client = $client;
        $this->link = $link;
    }

    public static function isRecipe($data)
    {
        return strpos($data, 'lesson-header-block') !== false;
    }

    protected function parseItems($content)
    {

        $html = str_get_html($content);

        $title = $html->find('.lesson-title-value', 0)->innertext;

        $recipeItemsVo = $this->parseRecipeItems($html);

        $img = @$html->find('.lite-page .image-box img', 0)->src;

        $link = Parser::BASE_URL . $this->link;

        return new RecipeVo($title, $link, $recipeItemsVo, $img);

    }

    public function parseRecipeItems($dom)
    {
        $recipeItems = $dom->find('.lite-page',0)->children();

        $recipeItemsVoList = [];

        foreach ($recipeItems as $item) {
            $recipeItemSubTexts = [];

            $title = @$item->find('.header p', 0)->innertext;

            if (!$title) {
                continue;
            }

            $subTexts = $item->find('.text p');


            foreach ($subTexts as $subText) {
                $recipeItemSubTexts[] = $subText->innertext;
            }

            $recipeItemVo = new RecipeItemsVo($title, $recipeItemSubTexts);

            $recipeItemsVoList[] = $recipeItemVo;
        }

        return $recipeItemsVoList;
    }

    public static function parseFromContent($content, Client $client, $link = null)
    {
        $parser = new self ($client, $link);
        return $parser->parseItems($content);
    }
}
