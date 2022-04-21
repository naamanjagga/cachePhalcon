<?php

namespace App\Components;


use Phalcon\Di\Injectable;
use Phalcon\Translate\Adapter\NativeArray;
use Phalcon\Translate\InterpolatorFactory;
use Phalcon\Translate\TranslateFactory;
use Phalcon\Cache;

class Locale extends Injectable
{

    public function getTranslator(): NativeArray
    {
        // Ask browser what is the best language

            // Get some configuration values
            
      
       
       

        $language = $this->request->getBestLanguage();

        if (isset($_GET['locale'])) {
            $lan = $_GET['locale'];
            $this->session->set("locale", $lan);
        }
        if ($this->cache->has('my-key') == $this->request->get("locale")) {
            $lan2 = $this->cache->get('my-key');
        } else {
            $lan2 = $this->request->get("locale");
            $this->cache->set('my-key', $lan2);
        }
        if (!$lan2) {
            $lan2 = $this->session->get("locale");
        }




        $messages = [];

        $translationFile = APP_PATH . '/messages/' . $language . '.php';

        if (true !== file_exists($translationFile)) {
            $translationFile = APP_PATH . '/messages/' . $lan2 . '.php';
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
