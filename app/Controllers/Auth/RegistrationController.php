<?php

namespace App\Controllers\Auth;

use App\Models\User\User;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;

class RegistrationController extends Controller
{

    /**
     * Return registration view
     *
     * @param [type] $request
     * @param [type] $response
     * @return void
     */
    public function create($request,$response)
    {
        return $this->view->render($response,'auth/create.twig');

    }

    public function store($request,$response)
    {
        /**
         * Handling validation
         */
        $Validator = $this->Validator->validate($request,[
                                'name' => v::notEmpty(),
                                'email' => v::email()->emailExist(),
                                'phone' => v::phone()->phoneExist(),
                                'role'  => v::notEmpty()
                            ]);
        
        // is validation failed
        if($Validator->failed())
        {
            return $response->withRedirect($this->router->pathFor('auth.register'));
        }

        /**
         * Generating random password and api token
         */

         $token  = openssl_random_pseudo_bytes(16);
         $api_token = bin2hex($token);

        //  password
        


        $password = "password";
        // rand(1000000,100000000);
   
       
        User::create([
            'name'     => $request->getParam('name'),
            'email'    => $request->getParam('email'),
            'password' => password_hash($password,PASSWORD_DEFAULT),
            'phone'    => $request->getParam('phone'),
            'role_id'  => $request->getParam('role'),
            'api_token' => $api_token,
        ]);

        // flash message
        $this->flash->addMessage('success','A new user  has been successfully added ');

        return $response->withRedirect($this->router->pathFor('user.index'));

    }

}