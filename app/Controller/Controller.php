<?php
namespace App\Controller;

use App\Model;
Use PDO;
use Twig_Environment;
use Symfony\Component\HttpFoundation\Request;

class Controller {
    protected $view;
    protected $request;
    protected $matcher;

    function __construct(Request $request,Twig_Environment $view,$matcher){
        $this->request = $request;
        $this->view = $view;
        $this->matcher = $matcher;
    }

    function getVar($var){
        $arr = $this->matcher->match($this->request->getPathInfo());
        
        if(array_key_exists($var,$arr)){
            return $arr[$var];
        }
        return false;
    }

}
