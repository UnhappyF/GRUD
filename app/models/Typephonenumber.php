<?php

use Phalcon\Mvc\Model;

class Typephonenumber extends Model{
	
public $id;
public $name;



public function initialize()
{
    $this->setConnectionService('dbPhonebook');
}

}
?>