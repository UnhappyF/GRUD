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
         echo "WELCOME";
         
        if($this->request->isPost()){
            $mail = $this->request->getPost('email');
            $pass = $this->request->getPost('password');  
            $user = User::findFirst(
            [
                'email=:mail: AND password = :pass:',
                'bind'=>[
                    'mail'=>$mail,
                    'pass'=>$pass,
                ],

            ]
        );
        if ($user !== null) {
            $this->_registerSession($user);

            $this->flash->success(
            'Добро пожаловать ' . $user->name
            );
            #Если юзер прошел авторизацию, то пропускаем его к контактам
            return $this->dispatcher->forward(
                    [
                        'controller' => 'phonebook',
                        'action'     => 'index',
                    ]
                );
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




