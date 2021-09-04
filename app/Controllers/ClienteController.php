<?php
namespace App\Controllers;

use App\Models\clientes;
use Respect\Validation\Validator as v;
use Laminas\Diactoros\Response\RedirectResponse;

class ClienteController extends CoreController{
    public function getClientesAction(){
        $clientes = clientes::all();
        return $this->renderHTML('cliente.twig',[
            'clientes' => $clientes
        ]);
    }

    public function postSaveClientesAction($request){
        $responseMessage = null;    //var para recuperar los mesajes q suceda durante la ejecucion

        if ($request->getMethod() == "POST") {
            $postData = $request->getParsedBody();

            $projectValidator = v::key('Cedula', v::stringType()->noWhitespace()->notEmpty())
                ->key('Nombres', v::stringType()->notEmpty()->noWhitespace());
            
            try {
                $projectValidator->assert($postData);

                $cliente = new clientes();
                $cliente->cedula = $postData['Cedula'];
                $cliente->nombres = $postData['Nombres'];
                $cliente->apellidos = $postData['Apellidos'];
                $cliente->direccion = $postData['Direccion'];
                $cliente->otros = $postData['otros'];
                $cliente->save();
                $responseMessage = 'saved';
            } catch (\Exception $e) {
                $responseMessage = $e->getMessage();
            }
        }

        if ($responseMessage == 'saved') {
            return new RedirectResponse('/clientes');
        }else{
            return $this->renderHTML('cliente.twig', [
                'responseMessage' => $responseMessage
            ]);
        }
    }
}