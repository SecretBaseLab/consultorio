<?php
namespace App\Controllers;

use App\Models\clientes;
use Respect\Validation\Validator as v;
use Laminas\Diactoros\Response\RedirectResponse;

class ExpedienteController extends CoreController{
    public function getExpedienteFormAction ($request){
        $cedula = $request->getAttribute('cedula');
        $cliente = clientes::where("cedula", $cedula)
                            ->get();
        // $cliente = clientes::where("cedula", "=", $cedula)
        //                     ->get();                 //? con operador logico
        // $clientes = clientes::whereCedula($id)->get();
        return $this->renderHTML('expediente.twig',[
            'cliente' => $cliente[0]    //? devuelve un obj de arrays, solo quiero el primero o bien usar first() por get()
        ]);
    }

    public function postNewExpedienteFormAction($request){
        $postData = $request->getParsedBody();
        $files = $request->getUploadedFiles(); 

        print_r($files);
        print_r( $postData);
        return $this->jsonReturn( $files );
    }
}