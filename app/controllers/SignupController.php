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
			$this->flash->error(
            'Данный никнейм занят, введите другой'
            );
            return $this->dispatcher->forward(
            [
                'controller' => 'signup',
                'action'     => 'index',
            ]
        );
		}
		elseif ($mailFind->count()!=0){
			$this->flash->error(
            'Данная почта уже зарегестрирована'
            );
            return $this->dispatcher->forward(
            [
                'controller' => 'signup',
                'action'     => 'index',
            ]
        );
        }
        elseif ($this->request->getPost()['password']==null){
        	$this->flash->error(
            'Введите пароль'
            );
             return $this->dispatcher->forward(
            [
                'controller' => 'signup',
                'action'     => 'index',
            ]
        );
		}
		elseif($this->request->getPost()['password']!=$this->request->getPost()['confirmPassword']){
			$this->flash->error(
            'Подтверждение не совпадает с паролем'
            );
            return $this->dispatcher->forward(
            [
                'controller' => 'signup',
                'action'     => 'index',
            ]
        );
		}
		else{
		$user->name = $this->request->getPost()['name'];
		$user->email = $this->request->getPost()['email'];
		$user->password = password_hash($this->request->getPost()['password'], PASSWORD_DEFAULT);
		$success = $user->save();
	          }  
		#$success = $user->save($this->request->getPost(), array('name', 'email','password'));
		if ($success) {
			$this->flash->success(
            'Акаунт создан.Для дальнейшей работы войдите в акаунт'
            );
            return $this->dispatcher->forward(
            [
                'controller' => 'index',
                'action'     => 'index',
            ]
        );
		} else {
			$this->flash->error(
            'Введите данные для регистрации'
            );
            return $this->dispatcher->forward(
            [
                'controller' => 'signup',
                'action'     => 'index',
            ]
        );	
		}
		$this->view->disable();
    }
}