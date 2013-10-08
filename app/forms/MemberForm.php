<?php

use \Phalcon\Forms\Element\Text;
use \Phalcon\Forms\Element\Password;
use \Phalcon\Forms\Element\Select;
use \Phalcon\Validation\Validator\Email;
use \Phalcon\Validation\Validator\Confirmation;

class MemberForm extends \Phalcon\Forms\Form
{
    public function initialize(Member $member, $options)
    {
        $this->add(new Text('name'));
        $this->add(new Text('username'));

        $email = new Text('email');
        $email->addValidator(new Email());
        $this->add($email);

		$gender = new Select('gender', array(
			'm' => 'Male',
			'f' => 'Female'
		));

		$this->add($gender);

        $password = new Password('password');
        $password->addValidator(new Confirmation(array(
            'message' => 'Password doesn\'t match confirmation',
            'with' => 'password_confirm'
        )));
        $this->add($password);
        $this->add(new Password('password_confirm'));
    }
}
