<?php

use Phalcon\Validation\Validator,
	Phalcon\Validation\ValidatorInterface,
	Phalcon\Validation\Message;
	
class DuplicateMemberEmailValidator extends Validator implements ValidatorInterface { 

	public function validate($validator, $attribute){
		$value = $validator->getValue($attribute);
		if (Member::findFirst("email = '$value'")) { 

			$validator->appendMessage(new Message(
				'Email already exists on another user!',
				$attribute, 
				'Email'
			));
			return false;
		}

		return true;
	}
}
