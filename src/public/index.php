<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Document</title>
</head>
</html>
<?php

use App\Components\Locale;

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Application;
use Phalcon\Events\Event;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Events\Manager;
use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Component;
use Phalcon\Security\JWT\Builder;
use Phalcon\Security\JWT\Signer\Hmac;



// Define some absolute path constants to aid in locating resources
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
require BASE_PATH . '/vendor/autoload.php';

// print_r(APP_PATH);
// die;
$loader = new \Phalcon\Loader();

$loader->registerNamespaces(
    [
        'App\Components' => APP_PATH . '/components/',
        'App\Handler' => APP_PATH . '/handler/'
    ]
);
$loader->register();

$di = new FactoryDefault();

include APP_PATH . '/config/router.php';

include APP_PATH . '/config/services.php';

$config = $di->getConfig();

include APP_PATH . '/config/loader.php';

$eventsManager = new Manager();
$di->set('EventsManager', $eventsManager);
$eventsManager->attach('order', new \App\Handler\EventHandler());


$application=new Application($di);
$eventsManager=new Manager();
$eventsManager->attach(
    'application:beforeHandleRequest',
    new \App\Handler\EventHandler()
);

$di->set(
    'EventsManager',
    $eventsManager
);

$di->set('locale', (new Locale())->getTranslator());

$application->setEventsManager($eventsManager);

try {
    // Handle the request
    $response = $application->handle(
        $_SERVER["REQUEST_URI"]
    );

    $response->send();
} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
}
