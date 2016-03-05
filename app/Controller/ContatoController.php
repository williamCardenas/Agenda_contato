<?php
namespace App\Controller;

use App\Services\ContatoService;
use App\Model\Contato;
use App\Model\ContatoEmailTipo;
use App\Model\ContatoTelefoneTipo;

use App\Exceptions\NotFoundException;

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
        return $this->view->render('contato_message.html',['sucess'=>'Contato salvo com sucesso']);
    }

    public function edit(){
        $idContato = $this->getVar('id');
        $contato = ContatoService::getContatoById($idContato);
        $emailTipo = ContatoEmailTipo::all();
        $telefoneTipo = ContatoTelefoneTipo::all();

        return $this->view->render('contato_edit.html',['contato'=>$contato,'emailTipo'=>$emailTipo,'telefoneTipo'=>$telefoneTipo]);
    }

    public function update(){
        $idContato = $this->getVar('id');
        $nome = !empty($this->request->request->get('nome'))? $this->request->request->get('nome') :'';
        $emailId = !empty($this->request->request->get('emailId'))? $this->request->request->get('emailId') :array();
        $emails = !empty($this->request->request->get('email'))? $this->request->request->get('email') :array();
        $emailTipo = !empty($this->request->request->get('emailTipo'))? $this->request->request->get('emailTipo') :array();
        $ddd = !empty($this->request->request->get('ddd'))? $this->request->request->get('ddd') :array();
        $telefoneId = !empty($this->request->request->get('telefoneId'))? $this->request->request->get('telefoneId') :array();
        $telefones = !empty($this->request->request->get('telefone'))? $this->request->request->get('telefone') :array();
        $telefoneTipo = !empty($this->request->request->get('telefoneTipo'))? $this->request->request->get('telefoneTipo') :array();
        $error;

        ContatoService::update($idContato, $nome, $emailId, $emails, $emailTipo, $telefoneId, $ddd, $telefones, $telefoneTipo,$error);

        $contato = ContatoService::getContatoById($idContato);
        $emailTipo = ContatoEmailTipo::all();
        $telefoneTipo = ContatoTelefoneTipo::all();

        if($error->count()>0){
            return $this->view->render('contato_edit.html',['contato'=>$contato,'emailTipo'=>$emailTipo,'telefoneTipo'=>$telefoneTipo,'error'=>$error]);
        }
        return $this->view->render('contato_message.html',['sucess'=>'Contato salvo com sucesso']);
    }

    public function delete(){
        try {
            $idContato = $this->getVar('id');
            $contato = ContatoService::deleteContatoById($idContato);
            return $this->view->render('contato_message.html',['sucess'=>'Contato deletado com sucesso']);
        } catch (NotFoundException $e) {
            return $this->view->render('contato_message.html',['error'=>[$e->getMessage()]]);
        }

    }
}
