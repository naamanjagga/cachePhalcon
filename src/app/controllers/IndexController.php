<?php

declare(strict_types=1);
use Phalcon\Mvc\Controller;
use Phalcon\Translate\Adapter\NativeArray;
use Phalcon\Translate\InterpolatorFactory;
use Phalcon\Translate\TranslateFactory;
use App\Components\Locale;

class IndexController extends Controller
{
    public function indexAction()
    {
        $var = new Locale();
        $this->view->t    = $var->getTranslator();
    }
 
}