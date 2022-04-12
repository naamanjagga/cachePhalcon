<?php

declare(strict_types=1);

use Phalcon\Mvc\Controller;

class AddorderController extends Controller
{
    public function indexAction()
    {
        $products = new Products();
        $products = Products::find();
        $this->view->value =  $products;
    }
    public function addAction()
    {
        $orders = new Orders();
        $orders->assign(
            $this->request->getPost(),
            [
                'customer_name',
                'address',
                'zipcode',
                'product',
                'quantity',
            ]
        );

        // Store and check for errors
        $success = $orders->save();
        $this->view->success = $success;

        if ($success) {
            $message = "Thanks for registering!";
            $eventHandler = $this->di->get('EventsManager');
            $eventHandler->fire('order:ordersave',$this);
        } else {
            $message = "Sorry, the following problems were generated:<br>"
                . implode('<br>', $orders->getMessages());
        }

        // passing a message to the view
        $this->view->message = $message;
    }
    public function seeAction()
    {
        $products = new Orders();
        $products = Orders::find();
        $this->view->value =  $products;
    }
}
