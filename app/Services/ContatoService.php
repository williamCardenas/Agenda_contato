<?php
namespace App\Services;
use App\Model\Contato;
use Illuminate\Database\Eloquent\Collection;
use App\Exceptions\DuplicateException;
use App\Exceptions\OnlyNumberException;
use App\Exceptions\LengthException;

class ContatoService{
    static $perPage = 10;

    public static function createContato($nome, Array $email,Array $emailTipo, Array $telefone,Array $telefoneTipo,&$error=null){
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
        if(count($email)>0 and $email[0]!=''){
            foreach($email as $em){
                try{
                    $email = ContatoEmailService::createEmail($em,$emailTipo[$index],$contato);
                    $contato->contatoEmail->push($email);
                } catch(DuplicateException $e)
                {
                    $error->push($e->getMessage());
                }
                $index++;
            }
        }

        $index = 0;
        if(count($telefone)>0 and $telefone[0]!=''){
            foreach($telefone as $tel){
                try{
                    $telefone = ContatoTelefoneService::createTelefone($tel,$telefoneTipo[$index],$contato);
                    $contato->contatoTelefone->push($telefone);
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
        return $contato;
    }
}
