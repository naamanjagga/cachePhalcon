<?php

$loader = new \Phalcon\Loader();


$loader->registerDirs(
    [
        $config->application->controllersDir,
        $config->application->modelsDir,
        $config->application->handlerDir,
        $config->application->componentsDir
    ]
    );

$loader->registerNamespaces(
    [
        'App\Components' => APP_PATH . '/components/',
        'App\Handler' => APP_PATH . '/handler/'
    ]
    );

$loader->register();