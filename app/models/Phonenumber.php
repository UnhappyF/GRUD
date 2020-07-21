<?php

use Phalcon\Mvc\Model;

class Phonenumber extends Model{
	

public $id;

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
		$this->belongsTo(
            'idTypePhoneNumber',
            'Typephonenumber',
            'id',
			['alias' => 'TypeNumber']
        );
	}

}
?>