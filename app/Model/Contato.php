<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class  Contato extends Model{

    protected $table = 'contato';
    protected $primaryKey = 'id_contato';
    protected $fillable = [
        'nome'
    ];
    public $timestamps = false;

    public function contatoEmail(){
         return $this->hasMany('App\Model\ContatoEmail','id_contato','id_contato');
    }

    public function contatoTelefone(){
         return $this->hasMany('App\Model\ContatoTelefone','id_contato','id_contato');
    }

}
