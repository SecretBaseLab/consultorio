<?php
namespace App\Controllers;

use App\Models\passMaster;
use Respect\Validation\Validator as v;
use Laminas\Diactoros\Response\RedirectResponse;

class contraseniaMasterController extends CoreController{
    public function getFormContraseñaMasterAction(){
        return $this->renderHTML('contraseniaMaster.twig');
    }

    public function postSaveContraseñaMasterAction($request){
        $responseMessage = null;    //var para recuperar los mesajes q suceda durante la ejecucion

        if ($request->getMethod() == "POST") {
            $postData = $request->getParsedBody();

            $projectValidator = v::key('passMaster', v::stringType()->noWhitespace()->notEmpty());
            
            try {
                $projectValidator->assert($postData);

                $cliente = new passMaster();
                $cliente->otros = $postData['passMaster'];
                $cliente->save();
                $responseMessage = 'saved';
            } catch (\Exception $e) {
                $responseMessage = $e->getMessage();
            }
        }

        return $this->renderHTML('contraseniaMaster.twig', [
            'responseMessage' => $responseMessage
        ]);
    }
}