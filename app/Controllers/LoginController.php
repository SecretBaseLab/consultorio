<?php
namespace App\Controllers;

use App\Models\clientes;
use Respect\Validation\Validator as v;
use Laminas\Diactoros\Response\RedirectResponse;

class LoginController extends CoreController{
    public function getFormLoginAction(){
        return $this->renderHTML('login.twig');
    }
}