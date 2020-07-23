<?php

use Phalcon\Mvc\Model;

class Group extends Model{
	
public $id;
public $name;



public function initialize()
{
    $this->setConnectionService('dbPhonebook');

	
	$this->hasManyToMany(
            'id',
            'PeopleGroup',
            'idGroup', 'idPeople',
            'People',
            'id',
			['alias' => 'Peopls']
        );

}

}
?>