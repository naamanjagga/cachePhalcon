<?php

declare(strict_types=1);

namespace App\console;

use Phalcon\Cli\Task;

class DelCacheTask extends Task
{
    public function mainAction()
    {
        if (true === is_file(APP_PATH . '/security/acl.cache')) {
            unlink(APP_PATH . '/security/acl.cache');
            // echo 'This is the default task and the default action' . PHP_EOL;
        } else {
            echo 'no file found';
        }
    }
}
