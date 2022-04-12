<?php

$loader = new \Phalcon\Loader();


$loader->registerDirs(
    [
        $config->application->controllersDir,
        $config->application->modelsDir,
        $config->application->handlerDir
    ]
    );

$loader->registerNamespaces(
    [
        'App\Handler' => APP_PATH . '/handler/'
    ]
    );

$loader->register();