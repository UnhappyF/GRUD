<?php
declare(strict_types=1);

class IndexController extends ControllerBase
{

    public function indexAction()
    {


    }

    private function _registerSession($user)
    {
        $this->session->set(
            'auth',
            [
                'id'   => $user->id,
                'name' => $user->name,
            ]
        );
    }

    public function signinAction()
    {
        if($this->request->isPost()){
            $user = User::findFirst(
            [
                'email=:mail:',
                'bind'=>[
                    'mail'=>$mail=$this->request->getPost('email'),
                ],
            ]
        );
        if ($user !== null && password_verify($this->request->getPost()['password'], $user->password)) {
            $this->_registerSession($user);
            $this->flash->success(
            'Добро пожаловать ' . $user->name
            );
            #Если юзер прошел авторизацию, то пропускаем его к контактам
            header("Location: /myspace");
            }
            $this->flash->error(
                'Неправильный пароль или Email адрес'
            );
        }
        #Пользователь не смог пройти авторизацию, выводим ему эту же страницу
        return $this->dispatcher->forward(
            [
                'controller' => 'index',
                'action'     => 'index',
            ]
        );
    }
}




