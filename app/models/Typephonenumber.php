<?php

use Phalcon\Mvc\Model;

class TypePhoneNumber extends Model{
	
public $id;
public $name;



public function initialize()
{
    $this->setConnectionService('dbPhonebook');
}

}
?>