<?php

use Phalcon\Di\Injectable;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Component;
use Phalcon\Acl\Role;
use Phalcon\Acl\Enum;

class SecurityPlugin extends Injectable
{
    

    public function beforeExecuteRoute(
        Event $event, 
        Dispatcher $containerspatcher
    ) {
        $auth = $this->session->get('auth');

        if (!$auth) {
            $role = 'Guests';
        } else {
            $role = 'Users';
        }

        $controller = $containerspatcher->getControllerName();
        $action     = $containerspatcher->getActionName();

        $acl = $this->getAcl();

        $allowed = $acl->isAllowed($role, $controller, $action);
        if (true !== $allowed) {
            $this->flash->error(
                "Ввойдите в акаунт для работы с сайтом"
            );
            $containerspatcher->forward(
                [
                    'controller' => 'index',
                    'action'     => 'index',
                ]
            );

            return false;
        }
    }

    protected function getAcl(): AclList
    {
        $acl = new AclList();
        $acl->setDefaultAction(
    Enum::DENY
);
        $roles = array( 
            'users' => new Role('Users'),
             'guests' => new Role('Guests') 
         );
        foreach ($roles as $role) {
         $acl->addRole($role); 
     }
     $privateResources = array(

<<<<<<< HEAD
      'phonebook' => array('index', 'search', 'new', 'edit', 'create','save', 'delete','myspace','exit'),
=======
      'phonebook' => array('index', 'search', 'new', 'edit', 'create','save', 'delete'),

>>>>>>> ec7d40b88e1051e18188b9656b67bb5cfb802313
      'myspace' => array('index', 'exit'),
      'changepass'=> array('index', 'exit', 'change', 'myspace'),
     );
     foreach ($privateResources as $componentName => $actions) {
    $acl->addComponent(
        new Component($componentName),
        $actions
    );
}
    $publicResources = array(
     'index' => array('index'),
      'signup' => array('index','register'),
      ); 
    foreach ($publicResources as $componentName => $actions) {
    $acl->addComponent(
        new Component($componentName),
        $actions
    );
}
 foreach ($roles as $role) {
  foreach ($publicResources as $resource => $actions) {
   $acl->allow($role->getName(), $resource, '*');
   }
 }
 foreach ($privateResources as $resource => $actions) { 
    foreach ($actions as $action) {
     $acl->allow('Users', $resource, $action); 
 }
      }

return $acl;

    }
}