<?php
namespace App\Services;
use App\Model\Contato;
use Illuminate\Database\Eloquent\Collection;
use App\Exceptions\DuplicateException;
use App\Exceptions\OnlyNumberException;
use App\Exceptions\LengthException;
use App\Exceptions\NotFoundException;
use Exception;

class ContatoService{
    static $perPage = 10;

    public static function createContato($nome, Array $email,Array $emailTipo, Array $ddd,Array $telefone,Array $telefoneTipo,&$error=null){
        $error = new Collection();
        try{
            if(!strlen($nome)>0){
                throw new LengthException("O nome deve ser preenchido");
            }
        } catch(LengthException $e){
            $error->push($e->getMessage());
            return null;
        }
        $contato = Contato::create(['nome'=>$nome]);
        $index = 0;
        if(count($email)>0){
            foreach($email as $em){
                try{
                    $email = ContatoEmailService::createEmail($em,$emailTipo[$index],$contato);
                    if($email){
                        $contato->contatoEmail->push($email);
                    }
                } catch(DuplicateException $e)
                {
                    $error->push($e->getMessage());
                }
                $index++;
            }
        }

        $index = 0;
        if(count($telefone)>0){
            foreach($telefone as $tel){
                try{
                    $telefone = ContatoTelefoneService::createTelefone($tel,$ddd[$index],$telefoneTipo[$index],$contato);
                    if($telefone){
                        $contato->contatoTelefone->push($telefone);
                    }
                } catch(DuplicateException $e)
                {
                    $error->push($e->getMessage());
                } catch(OnlyNumberException $e)
                {
                    $error->push($e->getMessage());
                } catch(LengthException $e)
                {
                    $error->push($e->getMessage());
                }
                $index++;
            }
        }

        return $contato;
    }

    public function update($contatoId, $nome, Array $emailId, Array $email, Array $emailTipo, Array $telefoneId,Array $ddd, Array $telefone,Array $telefoneTipo,&$error=null){
        $error = new Collection();
        $contato = self::getContatoById($contatoId);
        try{
            $count = 0;
            $contato->nome = $nome;
            foreach ($emailId as $id){
                ContatoEmailService::updateEmail($id,$email[$count],$emailTipo[$count]);
                $count++;
            }
            $count = 0;
            foreach($telefoneId as $id){
                ContatoTelefoneService::updateTelefone($id,$ddd[$count],$telefone[$count],$telefoneTipo[$count]);
                $count++;
            }
            $contato->save();
            if(count($email)>count($emailId)){
                $index = count($emailId);
                while($index < count($email)){
                    try{
                        $em = ContatoEmailService::createEmail($email[$index],$emailTipo[$index],$contato);
                        if($em){
                            $contato->contatoEmail->push($em);
                        }
                    } catch(DuplicateException $e){
                        $error->push($e->getMessage());
                    }
                    $index++;
                }
            }
            if(count($telefone)>count($telefoneId)){
                $index = count($telefoneId);
                while($index <= count($telefone)){
                    if(empty($telefone[$index])){
                        $index++;
                        continue;
                    }
                    try{
                        $tel = ContatoTelefoneService::createTelefone($telefone[$index],$ddd[$index],$telefoneTipo[$index],$contato);
                        if($tel){
                            $contato->contatoTelefone->push($tel);
                        }
                    } catch(DuplicateException $e){
                        $error->push($e->getMessage());
                    }
                    $index++;
                }
            }
        } catch(NotFoundException $e) {
            $error->push($e->getMessage());
        } catch(DuplicateException $e)
        {
            $error->push($e->getMessage());
        } catch(OnlyNumberException $e)
        {
            $error->push($e->getMessage());
        } catch(LengthException $e)
        {
            $error->push($e->getMessage());
        }
        return $contato;
    }

    public static function getContatoPaginated($page){
        $perPage = self::$perPage;
        $start = ($page-1)*$perPage;
        $end = ($start+$perPage)-1;
        $contato = Contato::skip($start)->take($perPage)->get();
        return $contato;
    }

    public static function getNumberPage(){
        $perPage = self::$perPage;
        $contato = Contato::count();
        return $contato/$perPage;
    }

    public static function getContatoById($id){
        $contato = Contato::find($id);
        if(empty($contato)){
            throw new NotFoundException("contato não encontrado");
        }
        $contato->load('contatoEmail');
        $contato->load('contatoTelefone');
        return $contato;
    }

    public static function deleteContatoById($id){
        $contato = self::getContatoById($id);
        if(empty($contato)){
            throw new NotFoundException("contato não encontrado");
        }
        foreach($contato->contatoEmail as $email){
            $email->delete();
        }
        foreach($contato->contatoTelefone as $telefone){
            $telefone->delete();
        }
        $contato->delete();
    }
}
