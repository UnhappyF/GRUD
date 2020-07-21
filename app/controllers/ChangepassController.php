<?php
declare(strict_types=1);

use Phalcon\Mvc\Controller;
class ChangepassController extends ControllerBase
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
    }
    public function exitAction()
    {
        $this->session->destroy();
        header("Location: /index");
    }

    public function changeAction()
    {
        $auth = $this->session->get('auth');
        $user = User::findFirst($auth['id']);

        if(password_verify($this->request->getPost()['temppassword'], $user->password)){
            if($this->request->getPost()['password']!=null && $this->request->getPost()['repeatePassword']!=null && $this->request->getPost()['password']==$this->request->getPost()['repeatePassword']){
                $user->password=password_hash($this->request->getPost()['password'], PASSWORD_DEFAULT);
                if($user->update()===false){
                    $this->flash->error(
                  'Ошибка при сохранении пароля'
                );
                    $this->dispatcher->forward([
                  'controller' => 'changepass',
                  'action'     => 'index',
                ]);
                return;
                  }
                  else{
                    $this->flash->success(
                  'Пароль успешно обновлен'
                );
                    $this->dispatcher->forward([
                  'controller' => 'changepass',
                  'action'     => 'index',
                ]);
                  }

            }
            else{
                $this->flash->error(
                  'Введенные пароли не совпадают или не введены'
                );
                $this->dispatcher->forward([
                  'controller' => 'changepass',
                  'action'     => 'index',
                ]);
                return;
            }
        }
        else{
            $this->flash->error(
                'Неправильный текущий пароль'
            );
            $this->dispatcher->forward([
                'controller' => 'changepass',
                'action'     => 'index',
            ]);
            return;
        }
    }

    public function MyspaceAction()
    {
        header("Location: /myspace");
    }
}