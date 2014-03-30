<?php

use \Phalcon\Forms\Form;
use \Phalcon\Forms\Element\Password;
use \Phalcon\Forms\Element\Text;
use \Phalcon\Forms\Element\Hidden;
use \Phalcon\Forms\Element\Submit;
use \Phalcon\Validation\Validator\PresenceOf;
use \Phalcon\Validation\Validator\Email;
use \Phalcon\Validation\Validator\Identical;

class LoginForm extends Form {
    public function initialize() {
        $email = new Text('email', array(
            'placeholder' => 'E-Mail'
        ));

        $email->addValidators(array(
            new PresenceOf(array(
                'message' => 'Your e-mail is required'
            )),
            new Email(array(
                'message' => 'That e-mail is not valid'
            ))
        ));

        $this->add($email);

        $password = new Password('password', array(
            'placeholder' => 'Password'
        ));

        $password->addValidator(new PresenceOf(array(
            'message' => 'Your password is required'
        )));

        $this->add($password);

        $csrf = new Hidden('csrf');

        $csrf->addValidator(new Identical(array(
            'value' => $this->security->getSessionToken(),
            'message' => 'CSRF validation has failed'
        )));

        $this->add($csrf);

        $this->add(new Submit('go', array(
            'class' => 'btn btn-success'
        )));
    }
}
