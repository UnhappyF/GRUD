<?php
declare(strict_types=1);

class IndexController extends ControllerBase
{

    public function indexAction()
    {

    }
    public function signinAction()
    {
    	if ($this->request->isPost()) {
    	$mail = $this->request->getPost('email');
    	$pass = $this->request->getPost('password');

    	if($mail != "" && $pass!=""){
    		echo "Успешный вход, временно так, потом будет лучше";
    	}
    	else if($mail == ""){
    		echo "Почта не введена";
    	}
    	else if ($pass == "") {
    		echo "<br>Пароль не введен";
    	}
    }


    }

}

