<?php

use Phalcon\Mvc\Model;

class Peoplegroup extends Model{
	
public $idPeople;
public $idGroup;



public function initialize()
{
    $this->setConnectionService('dbPhonebook');
	
	$this->belongsTo('idPeople', 'People', 'id', 
            array('alias' => 'peopls')
        );
        $this->belongsTo('idGroup', 'Group', 'id', 
            array('alias' => 'groups')
        );
}

}
?>