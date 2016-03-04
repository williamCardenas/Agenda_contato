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
        $error;
        $contato = ContatoService::createContato(
            $this->request->request->get('nome'),
            $this->request->request->get('email'),
            $this->request->request->get('emailTipo'),
            $this->request->request->get('ddd'),
            $this->request->request->get('telefone'),
            $this->request->request->get('telefoneTipo'),
            $error
        );

        if(empty($contato)){
            $emailTipo = ContatoEmailTipo::all();
            $telefoneTipo = ContatoTelefoneTipo::all();
            return $this->view->render('contato_novo.html',['emailTipo'=>$emailTipo,'telefoneTipo'=>$telefoneTipo,'error'=>$error]);
        }

        $contato->save();
        if($error->count()>0){
            $emailTipo = ContatoEmailTipo::all();
            $telefoneTipo = ContatoTelefoneTipo::all();
            return $this->view->render('contato_edit.html',['contato'=>$contato,'emailTipo'=>$emailTipo,'telefoneTipo'=>$telefoneTipo,'error'=>$error]);
        }
        return $this->view->render('contato_lista.html',['sucess'=>'Contato salvo com sucesso']);
    }

    public function edit(){
        $idContato = $this->getVar('id');
        $contato = ContatoService::getContatoById($idContato);
        $emailTipo = ContatoEmailTipo::all();
        $telefoneTipo = ContatoTelefoneTipo::all();
        $contato->load('contatoEmail');
        $contato->load('contatoTelefone');
        return $this->view->render('contato_edit.html',['contato'=>$contato,'emailTipo'=>$emailTipo,'telefoneTipo'=>$telefoneTipo]);
    }

    public function update(){
        $idContato = $this->getVar('id');
        $nome = $this->request->request->get('nome');
        $emailId = $this->request->request->get('emailId');
        $emails = $this->request->request->get('email');
        $emailTipo = $this->request->request->get('emailTipo');
        $ddd = $this->request->request->get('ddd');
        $telefoneId = $this->request->request->get('telefoneId');
        $telefones = $this->request->request->get('telefone');
        $telefoneTipo = $this->request->request->get('telefoneTipo');
        $error;

        ContatoService::update($idContato, $nome, $emailId, $emails, $emailTipo, $telefoneId, $ddd, $telefones, $telefoneTipo,$error);
    }
}
