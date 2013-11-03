<?php

use Phalcon\Validation\Validator,
	Phalcon\Validation\ValidatorInterface,
	Phalcon\Validation\Message;


class DuplicateDatabaseEntryValidator extends Validator implements ValidatorInterface { 
	
	private $field;

	public function __construct($field = null) { 
		if ($field === null ) { 
			throw new \Exception('Field must be passed to validator');
		}

		$this->field = $field;
	}

	public function validate ($validator, $attribute) { 

		$value = $validator->getValue($attribute);

		$field = strtolower($this->field);

		if (Member::findFirst("$field = '{$value}'")){
			$validator->appendMessage(new Message("{$this->field} must not exist", $attribute, $this->field));
			return false;
		}

		return true;
		
	}
}
