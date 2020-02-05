# Parser for lifestylefitness.getcourse.ru
Client wanted  parser for this website and use it everyday. I wanted to make mirror website but client at the end said he wanted offline pdf.
Here is demonstration parser.

If you want to use it clone the repo
```
git clone https://github.com/jasco-b/Parser-for-lifestylefitness.getcourse.ru.git
```
Add your login and password to the file config/params.php
```php
 'parser' => [
        'login' => 'mylogin',
        'password' => 'myPassword',
    ],
```

Use console command to make pdf files
```
php yii parser
```

It will save all pdf files to web/pdf folder.

## If you want to parse other url
Just change the commnad/ParserController to other url which you need.

## If you want to use in other controller just do folliwings:
```php 
        // if you want to parse other pages just use your own url
        $url ='https://lifestylefitness.getcourse.ru/teach/control/stream/view/id/128748431';
       
         // add your login and password here
        $login = '';
        $password='';
        
        $loginVo = new LoginVo($login, $password);
        $parser = new Parser($loginVo, $url);
        // this will parse the pages
        $items = $parser->parse();
```
