<?php
namespace App\Controller;

use App\Services\ContatoService;
use App\Model\Contato;
use App\Model\ContatoEmailTipo;
use App\Model\ContatoTelefoneTipo;


class ApiContatoController extends Controller{

    function contatoDetail(){
        $idContato = $this->request->request->get('id');

        if(!empty($idContato)){
            $contato = ContatoService::getContatoById($idContato);
            $contato->contatoEmail;
            $contato->contatoTelefone;
            foreach ($contato->contatoEmail as $email) {
                $email->tipo;
            }
            foreach ($contato->contatoTelefone as $telefone) {
                $telefone->FormatNumber();
                $telefone->tipo;
            }
            return $contato;
        }
    }
}
