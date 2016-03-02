<?php
namespace App\Controller;

use App\Services\ContatoService;
use App\Model\Contato;
use App\Model\ContatoEmailTipo;
use App\Model\ContatoTelefoneTipo;

class ContatoController extends Controller{

    function list(){
        $page = $this->getVar('page');
        $page = !empty($page)?$page:1;
        $contatos = ContatoService::getContatoPaginated($page);
        $pages = ceil(ContatoService::getNumberPage());
        //$contatos = Contato::all();
        return $this->view->render('contato_lista.html',['contatos'=>$contatos,'paginas'=>$pages]);
    }

    function new(){
        $emailTipo = ContatoEmailTipo::all();
        $telefoneTipo = ContatoTelefoneTipo::all();
        return $this->view->render('contato_novo.html',['emailTipo'=>$emailTipo,'telefoneTipo'=>$telefoneTipo]);
    }

    function save(){
        $contato = ContatoService::createContato(
            $this->request->request->get('nome'),
            $this->request->request->get('email'),
            $this->request->request->get('emailTipo'),
            $this->request->request->get('telefone'),
            $this->request->request->get('telefoneTipo')
        );
        $contato->save();
        return $this->view->render('contato_lista.html',['sucess'=>'Contato salvo com sucesso']);
    }
}
