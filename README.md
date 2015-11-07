DLF
====


Project structure
-------------------
```

autoloader/          autoloader
basic/               basic classes
    interfaces/      basic interfaces
components/          modules
    authorization/   authorization/identity module
    dbconnection/    database connection module
exception/           exception classes
web/                 web/net objects
```


Requirements
------------
 - PHP 5.4+

Installation
------------
DLF is available through [composer](https://getcomposer.org/)

composer require datalayerru/dlf "dev-master"

Alternatively you can add the following to the `require` section in your `composer.json` manually:

```json
"datalayerru/dlf": "dev-master"
```
Run `composer update` afterwards.


Initialization
--------------
##index.php
    ```php
require_once("../vendor/autoload.php");
require_once("../vendor/datalayerru/dlf/autoloader/Autoloader.php");

\dlf\autoloader\Autoloader::Register(new \dlf\autoloader\Basic());


$app = new \project\Application();
$app->run();
```
##Application.php
    ```php
namespace project;

use dlf\basic\RouteHandler;
use Symfony\Component\Yaml\Yaml;

class Application extends \dlf\basic\Application
{

    public function __construct()
    {
        parent::__construct(Yaml::parse(file_get_contents('../project/config/config.yaml')));

        RouteHandler::registerHandler('/',
            '\project\controllers\MainController::index');

        $this->getResponse()->setHeaders([
            "Access-Control-Allow-Headers: Content-Type",
            "Content-Type:text/html; charset=utf-8"
        ]);
    }
}
```

Controllers
-----------
```php
<?php

namespace project\controllers;

class MainController extends \dlf\basic\Controller
{

    public function index()
    {
        $this->title = 'Main page';

        return $this->render('project/views/main/index.php',
            [
                'name' => 'World!'
            ]);
    }
}
```


Views
-----
```html
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title><?= $title ?></title>
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
</head>
<body>
<div id="wrapper">
    <div id="page">
        <div id="content">
            Hello, <?= $name ?>!
        </div>
    </div>
</div>
</body>
</html>
```

Models
------
```php
class PostModel extends \dlf\basic\DBModel
{

    /**
     * @inheritdoc
     */
    public function getOne($primaryKeyValue)
    {
        $this->setAttrubutes($this->getDB()->query('SELECT * FROM post WHERE id=:id',
                [
                'id' => $primaryKeyValue
            ])->fetch(PDO::FETCH_ASSOC));

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function save()
    {

    }

    /**
     * @inheritdoc
     */
    public static function getAll(\dlf\components\dbconnection\interfaces\Connection $db)
    {
        $result = [];

        $rows = $db->query('SELECT * FROM post')->fetchAll();

        foreach ($rows as $value) {
            $o        = new PostModel($db);
            $o->setAttrubutes($value);
            $result[] = $o;
        }

        return $result;
    }

    public function validate($attributes = array())
    {
        return true;
    }
}
```



The MIT License (MIT)
---------------------

Copyright (c) 2015 Sergey Zinchenko, DataLayer.ru

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.