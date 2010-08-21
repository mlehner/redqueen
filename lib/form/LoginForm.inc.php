<?php

class LoginForm extends sfForm
{
    public function configure()
    {
        $this->setWidgets(array(
            'username' => new sfWidgetFormInput(),
            'password' => new sfWidgetFormInputPassword() 
        ));

        $this->widgetSchema->setNameFormat('login[%s]');

        $this->setValidators(array(
            'username' => new sfValidatorString(),
            'password' => new sfValidatorString()
        ));
    }
}
