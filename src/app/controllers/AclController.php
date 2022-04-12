<?php

declare(strict_types=1);

use Phalcon\Mvc\Controller;
use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;
use Phalcon\Acl\Component;

class AclController extends Controller
{
    public function indexAction()
    {
    }
    public function buildaclAction()
    {
        $aclFile = APP_PATH.'/security/acl.cache';
        // Check whether ACL data already exist
        if (true !== is_file($aclFile)) {

            // The ACL does not exist - build it
            $acl = new Memory();
            $user = Roles::find();
            
            foreach($user as $u){
               $acl->addRole($u->role);
               $acl->addComponent(
                $u->controller,
                [
                    $u->action,
                ]
            );

            $acl->allow($u->role, $u->controller, $u->action);

            }
            // ... Define roles, components, access, etc
            // $acl->allow('*','signup', 'index');

           

            
            // $acl->deny('guest', '*', '*');


            // Store serialized list into plain file
            file_put_contents(
                $aclFile,
                serialize($acl)
            );
        } else {
            // Restore ACL object from serialized file
            $acl = unserialize(
                file_get_contents($aclFile)
            );
        }
    }
}
