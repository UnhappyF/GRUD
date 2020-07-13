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
		echo $this->request->getPost()['name'];
		echo $this->request->getPost()['email'];
		echo $this->request->getPost()['password'];
		
		$user->name = $this->request->getPost()['name'];
		$user->email = $this->request->getPost()['email'];
		$user->password = $this->request->getPost()['password'];
		$success = $user->save();
		
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