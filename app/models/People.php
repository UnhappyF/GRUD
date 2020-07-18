<?php

use Phalcon\Mvc\Model;

class People extends Model{
	
public $id;
public $name;
public $secondName;
public $patronomic;
public $mail;
public $note;
public $chosen;
public $post;
public $birth;
public $organisationName;
public $city;
public $street;
public $house;
public $apNumber;

public function initialize()
{
    $this->setConnectionService('dbPhonebook');
	
	$this->hasMany(
            'id',
            'phoneNumber',
            'idPeople',
			['alias' => 'Phonenumber']
        );
}

}
?>