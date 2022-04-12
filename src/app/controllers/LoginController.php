<?php

declare(strict_types=1);

use Phalcon\Http\Response;
use Phalcon\Mvc\Controller;
use Phalcon\Security\JWT\Builder;
use Phalcon\Security\JWT\Signer\Hmac;
use Phalcon\Security\JWT\Token\Parser;
use Phalcon\Security\JWT\Validator;




class LoginController extends Controller
{
    public function indexAction()
    {
    
    }

    public function loginAction()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = Users::findFirstByemail($email);
        if ($user->password == $password) {
            $id = $user->id;
            $rem = $this->request->getPost('remember-me');

            $this->session->set("id", $id);
            $signer  = new Hmac();

            $builder = new Builder($signer);

            $now        = new DateTimeImmutable();
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
                    ->setSubject($user->role)   // sub
                    ->setPassphrase($passphrase)                // password 
            ;

            $tokenObject = $builder->getToken();

            $this->view->tokenObject = $tokenObject->getToken();
            if( $tokenObject !=null){
                $checkToken = 1;
            } else {
                echo 'access denied';
            }
            $this->view->tokenObject = $tokenObject;
            $this->view->checkToken = $checkToken;
            if ($this->session->has("id")) {
                $this->response->redirect('addproduct/add?bearer='.$tokenObject->getToken());
            }
        } else {
            echo ('Something went wrong');
            die();
        }
    }

    public function logoutAction()
    {
        $this->session->destroy();
        $this->response->redirect('index/index');
    }
}