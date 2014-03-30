<?php

class NewMemberForm extends MemberForm {

    public function initialize(Members $member, $options, $edit = false) {
        parent::initialize($member, $options, $edit);

        $username = $this->get('username');
        $username->addValidator(new DuplicateDatabaseMemberValidator('username'));

        $email = $this->get('email');
        $email->addValidator(new DuplicateDatabaseMemberValidator('email'));

        $password = $this->get('password');
        $password->addValidator(new PresenceOf(array(
            'message' => 'Password is required'
        )));

        $passwordConfirm = $this->get('password_confirm');
        $passwordConfirm->addValidator(new PresenceOf(array(
            'message' => 'Password is required'
        )));
    }
}
