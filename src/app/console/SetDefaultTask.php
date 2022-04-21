<?php

declare(strict_types=1);

namespace App\console;

use Phalcon\Cli\Task;
use Settings;

class SetDefaultTask extends Task
{
    public function mainAction($price = 10 , $stock = 10)
    {
        $setting = Settings::findFirstBydefault_id(1);
        $setting->d_price = $price; 
        $setting->d_stock = $stock; 
        $setting->save();
        echo 'updated price '.$price;
        echo ' and updated stock '.$stock;
    }
}