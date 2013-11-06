<?php

use \Phalcon\Forms\Element\Text;
use \Phalcon\Validation\Validator\PresenceOf;

class CardForm extends \Phalcon\Forms\Form 
{ 
	public function initialize(Cards $card, $options, $edi = false) {
		$pin = new Text('pin');
		$pin->addValidator(new PresenceOf(array(
			'message' => 'Pin is required'
		)));
		$this->add($pin);

		$code = new Text('code');
		$code->addValidator(new PresenceOf(array(
			'message' => 'Code is required'
		)));
		$code->addValidator(new DuplicateDatabaseCardValidator('code'));
		$this->add($code);
	}
}
