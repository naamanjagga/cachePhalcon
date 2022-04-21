<?php

declare(strict_types=1);

namespace App\console;

use Phalcon\Security\JWT\Builder;
use Phalcon\Security\JWT\Signer\Hmac;
use Phalcon\Cli\Task;

class AdminTokenTask extends Task
{
    public function mainAction($role = 'admin')
    {
        if ($role == 'admin') {
            $signer  = new Hmac();

            $builder = new Builder($signer);

            $now        = new \DateTimeImmutable();
            $issued     = $now->getTimestamp();
            $notBefore  = $now->modify('-1 minute')->getTimestamp();
            $expires    = $now->modify('+1 day')->getTimestamp();
            $passphrase = 'QcMpZ&b&mo3TPsPk668J6QH8JA$&U&m2';

            $builder
                ->setAudience('https://localhost')  // aud
                ->setContentType('application/json')        // cty - header
                ->setExpirationTime($expires)               // exp 
                ->setId('abcd123456789')                    // JTI id 
                ->setIssuedAt($issued)                      // iat 
                ->setIssuer('https://phalcon.io')           // iss 
                ->setNotBefore($notBefore)                  // nbf
                ->setSubject($role)   // sub
                ->setPassphrase($passphrase)                // password 
            ;

            $tokenObject = $builder->getToken();

            echo $tokenObject->getToken();
            die;
        } else {
            echo 'not an admin';
        }
        // echo 'This is the default task and the default action' . PHP_EOL;
    }
}
