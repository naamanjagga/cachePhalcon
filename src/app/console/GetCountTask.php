<?php

declare(strict_types=1);

namespace App\console;

use Phalcon\Cli\Task;
use Products;

class GetCountTask extends Task
{
    public function mainAction()
    {
        $product = Products::find('price < 20');;
        echo count($product);
    }
}
