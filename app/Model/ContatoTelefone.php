<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class  ContatoTelefone extends Model{

    protected $table = 'contato_telefone';
    protected $primaryKey = 'id_contato_telefone';
    protected $fillable = [
        'ddd','telefone','id_contato','id_contato_telefone_tipo'
    ];
    public $timestamps = false;

    public function tipo(){
         return $this->hasOne('App\Model\ContatoTelefoneTipo','id_contato_telefone_tipo','id_contato_telefone_tipo');
    }

    public function FormatNumber(){
        if(strlen($this->telefone)==8) $this->telefone = preg_replace("/^(\d{4})(\d{4})$/", "$1-$2", $this->telefone);
        if(strlen($this->telefone)==9) $this->telefone = preg_replace("/^(\d{5})(\d{4})$/", "$1-$2", $this->telefone);
    }

}
