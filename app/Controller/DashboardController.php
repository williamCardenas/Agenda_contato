<?php
namespace App\Controller;

class DashboardController extends Controller{

    function index(){
        return $this->view->render('dashboard.html');
    }

}
