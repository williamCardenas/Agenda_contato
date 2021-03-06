<?php
namespace App\Services;
use App\Model\Contato;
use App\Model\ContatoTelefone;
use App\Exceptions\DuplicateException;
use App\Exceptions\OnlyNumberException;
use App\Exceptions\LengthException;

class ContatoTelefoneService{

    private static function Validate($telefone,$ddd,$idTipo,$telefoneId=null){
        if(!is_numeric($telefone)){
            throw new OnlyNumberException("O telefone deve ter apenas numeros");
        }
        if(strlen($telefone)<8 or strlen($telefone)>9){
            throw new LengthException("O telefone deve ter entre oito e nove digitos");
        }
        if(empty($telefoneId)){
            $result = ContatoTelefone::where('telefone','=',$telefone)->count();
            if($result >0){
                throw new DuplicateException('O Telefone '.$telefone.' já foi cadastrado');
            }
        }else{
            $result = ContatoTelefone::where('telefone','=',$telefone)->where('id_contato_telefone','!=',$telefoneId)->count();
            if($result >0){
                throw new DuplicateException('O Telefone '.$telefone.' já foi cadastrado para outro contato');
            }
        }
    }

    public static function createTelefone($telefone,$ddd,$idTipo,Contato $contato){
        if(!empty($telefone)){

        self::Validate($telefone,$ddd,$idTipo);
        $telefone = ContatoTelefone::create(['telefone'=>$telefone,'ddd'=>$ddd,'id_contato_telefone_tipo'=>$idTipo,'id_contato'=>$contato->id_contato]);

        return $telefone;
        }
        return false;
    }

    public static function updateTelefone($telefoneId,$ddd,$telefone,$idTipo){
        self::Validate($telefone,$ddd,$idTipo,$telefoneId);
        $result = ContatoTelefone::find($telefoneId);
        if(empty($result)){
            throw new NotFoundException("O telefone ".$telefone." não foi encontrado");
        }
        $result->telefone = $telefone;
        $result->ddd = $ddd;
        $result->id_contato_telefone_tipo = $idTipo;
        $response = $result->save();
        return $response;
    }

    public static function deleteTelefone($id){
        $telefone =  ContatoTelefone::find($id);
        if($telefone){
            $telefone->delete();
            return true;
        }
        return false;
    }
}
