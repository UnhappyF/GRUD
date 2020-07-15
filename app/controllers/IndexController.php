<?php
declare(strict_types=1);

class IndexController extends ControllerBase
{

    public function indexAction()
    {

    }
    public function signinAction()
    {
        $mail = $this->request->getPost('email');
        $pass = $this->request->getPost('password');    
        $user = User::find(
            [
                'email=:mail: AND password = :pass:',
                'bind'=>[
                    'mail'=>$mail,
                    'pass'=>$pass,
                ],

            ]);
        if($mail == "" || $pass == ""){
            echo "Почта или пароль не введены";
        }
        else if($user->count() ==1)
        {
            header("Location: /phonebook");
        }
        else
        {
            echo "Неправильный логин или пароль";
        }
    }

}

