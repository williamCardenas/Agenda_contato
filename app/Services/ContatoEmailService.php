<?php
namespace App\Services;
use App\Model\Contato;
use App\Model\ContatoEmail;
use App\Exceptions\DuplicateException;
use App\Exceptions\OnlyNumberException;
use App\Exceptions\LengthException;

class ContatoEmailService{

    public static function createEmail($email,$idTipo,Contato $contato){
        $result = ContatoEmail::where('email','=',$email)->count();
        if($result >0){
            throw new DuplicateException('O Email '.$email.' já foi cadastrado');
        }
        $email = ContatoEmail::create(['email'=>$email,'id_contato_email_tipo'=>$idTipo,'id_contato'=>$contato->id_contato]);

        return $email;
    }
}
