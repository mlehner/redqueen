<?php

class ChangePasswordForm extends sfForm
{
    public function configure()
    {
        $this->setWidgets(array(
            'new_passwd' => new sfWidgetFormInputPassword(array('label' => 'New Password')),
            'new_passwd_confirm' => new sfWidgetFormInputPassword(array('label' => 'New Password Confirm'))
        ));

        $this->widgetSchema->setNameFormat('change_passwd[%s]');

        $this->setValidators(array(
            'new_passwd' => new sfValidatorString(),
            'new_passwd_confirm' => new sfValidatorString()
        ));

        $this->validatorSchema->setPostValidator(new sfValidatorSchemaCompare('new_passwd', '==', 'new_passwd_confirm', array(), array('invalid' => 'The new passwords must match!')));
    }
}
