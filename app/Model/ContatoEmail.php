<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class  ContatoEmail extends Model{

    protected $table = 'contato_email';
    protected $primaryKey = 'id_contato_email';
    protected $fillable = [
        'email',
        'id_contato',
        'id_contato_email_tipo'
    ];
    public $timestamps = false;

    public function tipo(){
         return $this->hasOne('App\Model\ContatoEmailTipo','id_contato_email_tipo','id_contato_email_tipo');
    }

}
