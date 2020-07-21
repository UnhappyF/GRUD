<?php
declare(strict_types=1);

class MyspaceController extends ControllerBase
{

    public function indexAction()
    {
    	$auth = $this->session->get('auth');
    	$user = User::findFirst($auth['id']);
        if (!$user) {
            $this->dispatcher->forward([
                'controller' => 'index',
                'action'     => 'index',
            ]);
            return;
        }
    	 $this->view->nick = $user->name;
    	 $this->view->email = $user->email;
    }
    public function exitAction()
    {
      	$this->session->destroy();
      	header("Location: /index");
    }
}