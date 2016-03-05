<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class  ContatoTelefoneTipo extends Model{

        protected $table = 'contato_telefone_tipo';
        protected $primaryKey = 'id_contato_telefone_tipo';
        protected $fillable = [
            'nome','id_contato_telefone_tipo'
        ];
        public $timestamps = false;

}
