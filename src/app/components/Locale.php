<?php

namespace App\Components;

use Phalcon\Di\Injectable;
use Phalcon\Translate\Adapter\NativeArray;
use Phalcon\Translate\InterpolatorFactory;
use Phalcon\Translate\TranslateFactory;

class Locale extends Injectable
{
    
    public function getTranslator(): NativeArray
    {
        // Ask browser what is the best language
        $language = $this->request->getBestLanguage();
        $lan2 = $this->request->get("locale");
        if(!$lan2){
            $lan2 = $this->session->get("locale");
        }
        $messages = [];
        
        $translationFile = APP_PATH.'/messages/' . $language . '.php';

        if (true !== file_exists($translationFile)) {
            $translationFile = APP_PATH.'/messages/'.$lan2.'.php';
        }
        
        require $translationFile;

        $interpolator = new InterpolatorFactory();
        $factory      = new TranslateFactory($interpolator);
        
        return $factory->newInstance(
            'array',
            [
                'content' => $messages,
            ]
        );
    }
}