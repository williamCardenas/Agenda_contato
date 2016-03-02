<?php
namespace App\Services;
use App\Model\Contato;
use App\Model\ContatoTelefone;
use App\Exceptions\DuplicateException;

class ContatoTelefoneService{

    public static function createTelefone($telefone,$idTipo,Contato $contato){
        $result = ContatoTelefone::where('telefone','=',$telefone)->count();
        if($result >0){
            throw new DuplicateException("the email alread exist");
        }
        $telefone = ContatoTelefone::create(['telefone'=>$telefone,'id_contato_telefone_tipo'=>$idTipo,'id_contato'=>$contato->id_contato]);

        return $telefone;
    }
}
