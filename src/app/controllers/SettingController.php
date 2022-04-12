<?php

declare(strict_types=1);

use Phalcon\Mvc\Controller;

class SettingController extends Controller
{
    public function indexAction()
    {
    }
    public function addAction()
    {
        $settings = new Settings();
        $settings = Settings::find();
        //assign value from the form to $user
        if ($settings->count() == 1) {
            $setting = Settings::findFirstBydefault_id(1);
            $tags = $this->request->getPost('title');
            $price = $this->request->getPost('price');
            $stock = $this->request->getPost('stock');
            $zipcode = $this->request->getPost('zipcode');
            if ($tags != null) {
                $setting->product_type = $tags;
                $setting->save();
            }
            if ($price != null) {
                $setting->d_price = $price;
                $setting->save();
            }
            if ($stock != null) {
                $setting->d_stock = $stock;
                $setting->save();
            }
            if ($zipcode != null) {
                $setting->d_zipcode = $zipcode;
                $setting->save();
            }
        } else {
            $settings->assign(
                $this->request->getPost(),
                [
                    'product_type',
                    'd_price',
                    'd_stock',
                    'd_zipcode'
                ]
            );

            // Store and check for errors
            $success = $settings->save();
            $this->view->success = $success;

            if ($success) {
                $eventHandler = $this->di->get('EventsManager');
                $eventHandler->fire('order:productsave', $this);
                $message = "Thanks for registering!";
            } else {
                $message = "error";
            }
        }
    }
}
