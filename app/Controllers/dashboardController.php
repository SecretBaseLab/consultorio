<?php
namespace App\Controllers;

use App\Models\usuarios;
use Respect\Validation\Validator as v;
use Laminas\Diactoros\Response\RedirectResponse;


class loginController extends CoreController{
    public function getDashboardAction(){
        return $this->renderHTML('dashboard.twig');
    }
}