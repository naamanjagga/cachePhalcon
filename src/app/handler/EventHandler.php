<?php

declare(strict_types=1);


namespace App\Handler;

use Phalcon\Mvc\Application;
use Phalcon\Mvc\Controller;
use Phalcon\Events\Event;
use Phalcon\Security\JWT\Token\Parser;
use Phalcon\Security\JWT\Validator;
use Phalcon\Mvc\Dispatcher;
use Products;
use Orders;
use Settings;
use Roles;


class EventHandler extends Controller
{
    public function productsave()
    {
        $setting = Settings::findFirstBydefault_id(1);
        $price = $setting->d_price;
        $stock = $setting->d_stock;
        $tag = $setting->product_type;
        $product = Products::findFirst(['order' => 'id DESC']);
        if ($tag == 'with') {
            $pro = Products::find();
            foreach ($pro as $product) {
                echo $product->name;

                $product->name = $product->name . " " . $product->tags;
                $product->save();
            }
        }
        if ($product->price == 0) {
            $product->price = $price;
            $product->save();
        }
        if ($product->stock == 0) {
            $product->stock = $stock;
            $product->save();
        }

        $product->save();
    }
    public function ordersave()
    {
        $setting = Settings::findFirstBydefault_id(1);
        $zip = $setting->d_zipcode;
        $order = Orders::findFirst(['order' => 'order_id DESC']);
        if ($order->zipcode == 0) {
            $order->zipcode = $zip;
        }
        $order->save();
    }
    public function beforeHandleRequest(EVENT $event, Application $application, Dispatcher $containerspatcher)
    {
        $aclFile = APP_PATH . '/security/acl.cache';
        if (true === is_file($aclFile)) {
            $acl = unserialize(
                file_get_contents($aclFile)
            );

            //         $user = $application->request->get('role');
            //         $role =  Roles::findFirst(['conditions' => "role = '$user'"]);
            //         // foreach ($role as $r) {  
            //         if (true !== $acl->isAllowed($user, $role->controller, $role->action)) {
            //             echo 'Access denide';
            //             die();
            //         } else {
            //         }
            //         // }
            //     } else {
            //         echo 'file not found';
            //         die;

            $bearer = $application->request->get('bearer');
            if ($bearer) {
                try {
                    $parser = new Parser();
                    $tokenObject = $parser->parse($bearer);
                    $now        = new \DateTimeImmutable();
                    $expires    = $now->getTimestamp();
                    // $expires    = $now->modify('+1 day')->getTimestamp();

                    $validator = new Validator($tokenObject, 100);
                    $validator->validateExpiration($expires);
                    // echo 'validate';
                    // die;

                    $claim = $tokenObject->getClaims()->getPayload();
                    $user = $claim['sub'];
                   
                   

                    
                } catch (\Exception $e) {
                    echo $e->getMessage();
                    die;
                }
                $role =  Roles::findFirst(['conditions' => "role = '$user'"]);
                $controller = $containerspatcher->getControllerName();
                $action     = $containerspatcher->getActionName();
                if (true !== $acl->isAllowed($user, $controller, $action)) {
                    echo 'Access denied';
                    die();
                } else {
                }
            } 
        } else {
            echo 'file not found';
            die;
        }
    }
}
