<?php
/**
 * Created by PhpStorm.
 * User: jasurbek
 * Date: 2020-01-11
 * Time: 14:09
 */

namespace app\parser\classes;


use app\parser\exceptions\LoginException;
use app\parser\vo\LoginVo;
use GuzzleHttp\Client;
use yii\helpers\ArrayHelper;

class Login
{
    /**
     * @var string
     */
    private $link;
    /**
     * @var Client
     */
    private $client;


    protected $loginVo;


    /**
     * Login constructor.
     * @param $link string https://lifestylefitness.getcourse.ru/cms/system/login?required=1
     */
    public function __construct(LoginVo $loginVo, Client $client)
    {
        $this->link = '/cms/system/login'; //'https://lifestylefitness.getcourse.ru/cms/system/login';;
        $this->client = $client;
        $this->loginVo = $loginVo;
    }

    public function login()
    {
        $res = $this->client->get($this->link);
        $content = $res->getBody()->getContents();

        $params = $this->parseParams($content);


        $paramsToSend = [
            "action" => "processXdget",
            "xdgetId" => ArrayHelper::getValue($params, 'xdgetId'),
            'params' => [
                'action' => ArrayHelper::getValue($params, 'actionId'),
                'url' => $this->link,
                'email' => $this->loginVo->login,
                'password' => $this->loginVo->password,
                'object_type' => ArrayHelper::getValue($params, 'gcsObjectType'),
                'object_id' => ArrayHelper::getValue($params, 'gcsObjectId'),
            ],
            'requestTime' => ArrayHelper::getValue($params, 'requestTime'),
            'requestSimpleSign' => ArrayHelper::getValue($params, 'requestSimpleSign'),
        ];

        $res = $this->client->post($this->link, [
            'headers' => [
                'X-Requested-With' => 'XMLHttpRequest',
                'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36',
                'Sec-Fetch-Site' => 'same-origin',
                'Sec-Fetch-Mode' => 'cors',
                'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8',
            ],
            'form_params' => $paramsToSend,
        ]);

        $content = json_decode($res->getBody()->getContents(), 1);

        if (!isset($content['user_id'])) {
            throw new LoginException($content['errorMessage']);
        }

        $this->client->get($content['redirectUrl']);

        return true;
    }


    public function parseParams($content)
    {
        $params = $this->parseWindowParas($content);
        $params['xdgetId'] = $this->parseXdgetId($content);

        return $params;
    }

    public function parseWindowParas($content)
    {
        preg_match_all('/window.(.+)\s?=\s?(.+);/m', $content, $matches, PREG_SET_ORDER, 0);

        $founds = [];
        $trimmedMathes = array_map(function ($item) {
            $arr = [];
            if (!isset($item[1], $item[2])) {
                return [];
            }

            $arr['text'] = trim($item[1]);
            $arr['value'] = trim($item[2]);

            return $arr;

        }, $matches);


        foreach ($trimmedMathes as $match) {
            if (!isset($match['value'])) {
                continue;
            }

            $field = $match['text'];
            $value = str_replace('"', '', $match['value']);


            if (!in_array($field, self::paramsToParse())) {
                continue;
            }

            $founds[$field] = $value;
        }

        return $founds;

    }

    public static function paramsToParse()
    {
        return [
            'gcsObjectType',
            'gcsObjectId',
            'requestTime',
            'requestSimpleSign',
            'actionId',
        ];
    }

    public function parseXdgetId($content)
    {
        $reg = '/<form .+ (data-xdget-id=\"(.+)\")\s/m';
        preg_match($reg, $content, $matches);
        return end($matches);
    }


}
