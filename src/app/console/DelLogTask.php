<?php

declare(strict_types=1);

namespace App\console;

use Phalcon\Cli\Task;

class DelLogTask extends Task
{
    public function mainAction()
    {
        
        
        if (true === is_file(APP_PATH . '/log/login.log')) {
            unlink(APP_PATH . '/log/login.log');
        } else {
            echo 'no file found';
        }
        if (true === is_file(APP_PATH . '/log/signup.log')) {
            unlink(APP_PATH . '/log/signup.log');
        } else {
            echo 'no file found';
        }
    }
}