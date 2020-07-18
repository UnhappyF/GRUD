<?php

use Phalcon\Mvc\Model;

class Phonenumber extends Model{
	
public $phoneNumber;
public $idOperator;
public $idPeople;
public $idTypePhoneNumber;


	public function initialize()
	{
		$this->setConnectionService('dbPhonebook');
		
		$this->belongsTo(
            'idPeople',
            'People',
            'id',
			['alias' => 'People']
        );
	}

	
}
?>