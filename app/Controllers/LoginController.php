<?php
namespace App\Controllers;

use App\Models\usuarios;
use Respect\Validation\Validator as v;
use Laminas\Diactoros\Response\RedirectResponse;


class loginController extends CoreController{
    public function getFormLoginAction(){
        return $this->renderHTML('login.twig');
    }

    public function postSignUpAction($request){
        $responseMessage = null;    //var para recuperar los mesajes q suceda durante la ejecucion

        if ($request->getMethod() == "POST") {
            $postData = $request->getParsedBody();
            
            $usuariosValidator = v::key('cedula', v::stringType()->noWhitespace()->notEmpty())
            ->key('rol', v::stringType()->notEmpty()->noWhitespace())
            ->key('nombres', v::stringType()->notEmpty()->noWhitespace())
            ->key('apellidos', v::stringType()->notEmpty()->noWhitespace())
            ->key('telefono', v::stringType()->notEmpty()->noWhitespace())
            ->key('email', v::stringType()->notEmpty()->noWhitespace())
            ->key('username', v::stringType()->notEmpty()->noWhitespace())
            ->key('password', v::stringType()->notEmpty()->noWhitespace());

            $existeusuarios = '';
            try {
                $usuariosValidator->assert($postData);   //? validando

                $usuarios = new usuarios();

                $existeusuarios = $usuarios
                            ->where("cedula", '0202519914')
                            ->select('cedula')
                            ->first();
                if ( isset($existeusuarios->cedula) ) {
                    $responseMessage = 'Este usuario ya esta registrado';
                }else{
                    $usuarios->cedula = $postData['cedula'];
                    $usuarios->rol = $postData['rol'];
                    $usuarios->nombres = $postData['nombres'];
                    $usuarios->apellidos = $postData['apellidos'];
                    $usuarios->telefono = $postData['telefono'];
                    $usuarios->correo = $postData['email'];
                    $usuarios->user_name = $postData['username'];
                    $postData['password'] = password_hash($postData['password'], PASSWORD_DEFAULT );
                    $usuarios->password = $postData['password'];
                    $usuarios->save();
                    $responseMessage = 'Se ha guardado con éxito';
                    return new RedirectResponse('/dashboard');
                }
                            
            } catch (\Exception $e) {
                $responseMessage = 'Ha ocurrido un error! Informe a soporte';
                $responseMessage = $e->getMessage();
            }
            // return $this->jsonReturn($existeusuarios);

            return $this->renderHTML('login.twig', [
                'responseMessage' => "
                <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    $responseMessage
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>"
            ]);
            
        }
    }
}