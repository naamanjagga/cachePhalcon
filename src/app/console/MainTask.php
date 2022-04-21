<?php

declare(strict_types=1);

namespace App\console;

use Phalcon\Cli\Task;

class MainTask extends Task
{
    public function mainAction()
    {
        echo 'This is the default task and the default action' . PHP_EOL;
    }
    public function namanAction($naman)
    {
        echo $naman . PHP_EOL;
    }

}