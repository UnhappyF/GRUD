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
		
		$success = $user->save($this->request->getPost(), array('name', 'email','phone','password'));
		if ($success) {
			echo "Регистрация прошла успешно!";
		} else {
			echo "Ошибка: ";
			foreach ($user->getMessages() as $message) {
				echo $message->getMessage(), "<br/>";
			}
		}
		$this->view->disable();
    }
}