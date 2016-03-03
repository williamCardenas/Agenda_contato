<?php
namespace App\Services;
use App\Model\Contato;
use App\Model\ContatoTelefone;
use App\Exceptions\DuplicateException;
use App\Exceptions\OnlyNumberException;
use App\Exceptions\LengthException;

class ContatoTelefoneService{

    public static function createTelefone($telefone,$idTipo,Contato $contato){
        if(!is_numeric($telefone)){
            throw new OnlyNumberException("O telefone deve ter apenas numeros");
        }
        if(strlen($telefone)<8 or strlen($telefone)>9){
            throw new LengthException("O telefone deve ter entre oito e nove digitos");
        }
        $result = ContatoTelefone::where('telefone','=',$telefone)->count();
        if($result >0){
            throw new DuplicateException('O Telefone '.$telefone.' já foi cadastrado');
        }
        $telefone = ContatoTelefone::create(['telefone'=>$telefone,'id_contato_telefone_tipo'=>$idTipo,'id_contato'=>$contato->id_contato]);

        return $telefone;
    }
}
