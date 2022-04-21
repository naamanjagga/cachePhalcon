<?php

declare(strict_types=1);

namespace App\console;

use Phalcon\Cli\Task;
use Orders;

class NewOrderTask extends Task
{
    public function mainAction()
    {
        $orders = Orders::find(['order' => 'order_id DESC','limit' => 3]);
        foreach ($orders as $o) {
            echo $o->order_id;
        }
    }
}