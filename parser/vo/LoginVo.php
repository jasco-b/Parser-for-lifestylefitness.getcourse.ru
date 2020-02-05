<?php
/**
 * Created by PhpStorm.
 * User: jasurbek
 * Date: 2020-01-14
 * Time: 15:36
 */

namespace app\parser\vo;


class LoginVo
{
    public $login;
    public $password;

    public function __construct($login, $password)
    {
        $this->login = $login;
        $this->password = $password;
    }
}
