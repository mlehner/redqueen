<?php

use \Phalcon\Forms\Element\Text;
use \Phalcon\Forms\Element\Password;
use \Phalcon\Forms\Element\Select;
use \Phalcon\Validation\Validator\Email;
use \Phalcon\Validation\Validator\Confirmation;
use \Phalcon\Validation\Validator\PresenceOf;

class QuickAddForm extends \Phalcon\Forms\Form
{
    public function initialize()
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
        $email->addValidator(new DuplicateDatabaseMemberValidator('email'));
        $this->add($email);

        $pin = new Password('pin');
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
