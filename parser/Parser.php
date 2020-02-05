<?php
/**
 * Created by PhpStorm.
 * User: jasurbek
 * Date: 2020-01-11
 * Time: 13:25
 */

namespace app\parser;


use app\parser\classes\Login;
use app\parser\classes\ParseAll;
use app\parser\vo\LoginVo;
use GuzzleHttp\Client;

class Parser
{

    const BASE_URL = 'https://lifestylefitness.getcourse.ru';
    private $loginVo;
    private $parseToBegin;
    protected $request;

    public function __construct(LoginVo $loginVo, $parseToBegin)
    {
        $this->parseToBegin = $parseToBegin;
        $this->loginVo = $loginVo;
    }

    public function parse()
    {

        $login = new Login($this->loginVo, $this->getRequest());
        $login->login();


      $parser = new ParseAll($this->getRequest(), $this->parseToBegin);

      return $parser->parse();

    }

    /**
     * @return Client
     */
    protected function getRequest()
    {
        if (!$this->request) {
            $jar = new \GuzzleHttp\Cookie\CookieJar();
            $this->request = new Client([
                'allow_redirects' => true,
                'cookies' => $jar,
                'base_uri' => self::BASE_URL,
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36'
                ]
            ]);
        }
        return $this->request;

    }

}
