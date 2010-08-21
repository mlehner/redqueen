<?php

class NewMemberForm extends sfForm
{
    public function configure()
    {
        $this->setWidgets(array(
            'first_name' => new sfWidgetFormInput(),
            'last_name' => new sfWidgetFormInput(),
            'nickname' => new sfWidgetFormInput(),
            'email' => new sfWidgetFormInput(),
            'username' => new sfWidgetFormInput(),
            'password' => new sfWidgetFormInputPassword(),
            'password_confirm' => new sfWidgetFormInputPassword()
        ));

        $this->widgetSchema->setNameFormat('new_member[%s]');

        $this->widgetSchema->setHelp('first_name', 'Your first (given) name. Only available to directors and officers.');
        $this->widgetSchema->setHelp('last_name', 'Your last (sur) name. Only available to directors and officers.');
        $this->widgetSchema->setHelp('nickname', 'This is the name you would like displayed publicly.');
        $this->widgetSchema->setHelp('email', 'This is the email address used by directors and officers to contact you.');
        $this->widgetSchema->setHelp('username', 'The username you would like to use for authenticating to services.');
        $this->widgetSchema->setHelp('password', 'Your password for authenticating.');
        $this->widgetSchema->setHelp('password_confirm', 'Confirm your password for authenticating.');

        $this->setValidators(array(
            'first_name' => new sfValidatorString(),
            'last_name' => new sfValidatorString(),
            'username' => new sfValidatorUsername(),
            'nickname' => new sfValidatorString(),
            'email' => new sfValidatorEmail(),
            'password' => new sfValidatorString(),
            'password_confirm' => new sfValidatorString()
        ));

        $this->validatorSchema->setPostValidator(new sfValidatorSchemaCompare('password', '==', 'password_confirm', array(), array('invalid' => 'The passwords must match!')));
    }
}
