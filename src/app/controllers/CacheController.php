<?php

declare(strict_types=1);
use Phalcon\Mvc\Controller;
use Phalcon\Cache;
use Phalcon\Cache\AdapterFactory;
use Phalcon\Storage\SerializerFactory;

class CacheController extends Controller
{
    public function indexAction()
    {
      

        $cacheFile = APP_PATH.'/security/new.cache';
        // Check whether ACL data already exist
        if (true !== is_file($cacheFile)) {

            // The ACL does not exist - build it
            $acl = new Memory();
            
            file_put_contents(
                $cacheFile,
                serialize($acl)
            );
        } else {
            $acl = unserialize(
                file_get_contents($cacheFile)
            );
        }


        $serializerFactory = new SerializerFactory();
        $adapterFactory    = new AdapterFactory($serializerFactory);
       
        $options = [
            'defaultSerializer' => 'Json',
            'lifetime'          => 7200
        ];
        
        $adapter = $adapterFactory->newInstance('apcu', $options);
        
        $cache = new Cache($adapter);

        $data = 'naman';
        $result = $cache->set('my-key', $data);
        return 'naman';
        echo $result; die;
    }
 
}



