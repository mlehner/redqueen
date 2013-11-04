<?php

use \Phalcon\Forms\Element\Text;

class CardForm extends \Phalcon\Forms\Form 
{ 
	public function initialize(Card $card, $options, $edi = false) {
		$this->add(new Text('pin'));
		$this->add(new Text('code'));
	}
}
