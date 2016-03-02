<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class  ContatoEmailTipo extends Model{

        protected $table = 'contato_email_tipo';
        protected $primaryKey = 'id_contato_email_tipo';
        protected $fillable = [
            'nome'
        ];
        public $timestamps = false;

}
