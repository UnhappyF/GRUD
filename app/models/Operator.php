<?php

use Phalcon\Mvc\Model;

class Operator extends Model{
	
public $id;
public $name;
public $code;


public function initialize()
{
    $this->setConnectionService('dbPhonebook');
}

}
?>