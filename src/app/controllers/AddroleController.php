<?php

declare(strict_types=1);

use Phalcon\Mvc\Controller;

class AddroleController extends Controller
{
    public function indexAction()
    {
    }
    public function addAction()
    {
        $role = new Roles();

        //assign value from the form to $user
        $role->assign(
            $this->request->getPost(),
            [
                'role',
                'controller',
                'action',
            ]
        );

        // Store and check for errors
        $success = $role->save();
        $this->view->success = $success;

        if ($success) {
            $eventHandler = $this->di->get('EventsManager');
            $eventHandler->fire('order:roleave', $this);
            $message = "Thanks for registering!";
        } else {
            $message = "error";
        }
    }
}
