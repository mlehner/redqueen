<?php

use Phalcon\Validation\Validator,
	Phalcon\Validation\ValidatorInterface,
	Phalcon\Validation\Message;
	
class DuplicateMemberUsernameValidator extends Validator implements ValidatorInterface { 

	public function validate($validator, $attribute){
		$value = $validator->getValue($attribute);
		if (Member::findFirst("username = '$value'")) { 
			$validator->appendMessage(new Message(
				'Username already exists',
				$attribute, 
				'Username'
			));

			return false;
		}
		return true;
	}
}
