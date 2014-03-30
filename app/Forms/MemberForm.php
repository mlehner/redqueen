<?php

use \Phalcon\Forms\Element\Text;
use \Phalcon\Forms\Element\Password;
use \Phalcon\Forms\Element\Select;
use \Phalcon\Validation\Validator\Email;
use \Phalcon\Validation\Validator\Confirmation;
use \Phalcon\Validation\Validator\PresenceOf;

class MemberForm extends \Phalcon\Forms\Form
{
    public function initialize(Members $member, $options, $edit = false)
    {
        $name = new Text('name');
        $name->addValidator(new PresenceOf(array(
            'message' => 'Full name is required'
        )));
        $this->add($name);

        $email = new Text('email');
        $email->addValidator(new Email());
        $email->addValidator(new PresenceOf(array(
            'message' => 'Email is required'
        )));
        $this->add($email);

        $password = new Password('password');
        $password->addValidator(new Confirmation(array(
            'message' => 'Password doesn\'t match confirmation',
            'with' => 'password_confirm'
        )));
        $this->add($password);

        $passwordConfirm = new Password('password_confirm');
        $this->add($passwordConfirm);
    }
}
