<?php
namespace App\Services;
use App\Model\Contato;
use App\Model\ContatoEmail;
use App\Exceptions\DuplicateException;
use App\Exceptions\OnlyNumberException;
use App\Exceptions\LengthException;
use App\Exceptions\NotFoundException;

class ContatoEmailService{

    public static function createEmail($email,$idTipo,Contato $contato){
        if(!empty($email)){

            $result = ContatoEmail::where('email','=',$email)->count();
            if($result >0){
                throw new DuplicateException('O Email '.$email.' já foi cadastrado');
            }
            $email = ContatoEmail::create(['email'=>$email,'id_contato_email_tipo'=>$idTipo,'id_contato'=>$contato->id_contato]);
            var_dump($email);
            exit;

            return $email;
        }
        return false;
    }

    public static function updateEmail($emailId,$email,$idTipo){
        $result = ContatoEmail::find($emailId);
        if(empty($result)){
            throw new NotFoundException("O email ".$email." não foi encontrado");
        }
        $result->email = $email;
        $result->id_contato_email_tipo = $idTipo;
        return $result->save();
    }
}
