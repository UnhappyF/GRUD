<?php

use Phalcon\Mvc\Controller;

class SignupController extends Controller
{
    public function indexAction()
    {

    }
	public function registerAction()
    {
    	$user = new User();
		$success =FALSE;
		#Проверка почты на существование
		$mail =$this->request->getPost()['email'];
		$mailFind = User::find(
			  [
                'email=:mail:',
                'bind'=>[
                    'mail'=>$mail,
                ],
            ]
		);
        #Проверка ника на существование
        $name =$this->request->getPost()['name'];
		$nameFind = User::find(
			  [
                'name=:name:',
                'bind'=>[
                    'name'=>$name,
                ],
            ]
		);
		if($nameFind->count()!=0){
			echo "Данный никнейм занят, введите другой";
		}
		elseif ($mailFind->count()!=0){
			echo "Данная почта уже зарегестрирована";
		}
		else{
		$user->name = $this->request->getPost()['name'];
		$user->email = $this->request->getPost()['email'];
		$user->password = password_hash($this->request->getPost()['password'], PASSWORD_DEFAULT);
		$success = $user->save();
	          }  
		#$success = $user->save($this->request->getPost(), array('name', 'email','password'));
		if ($success) {
			echo "Регистрация прошла успешно!";
		} else {
			echo "Ошибка: <br/>";
			foreach ($user->getMessages() as $message) {
				echo $message->getMessage(), "<br/>";
			}
		}
		$this->view->disable();
    }
}