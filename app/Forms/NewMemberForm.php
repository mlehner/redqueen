<?php

class NewMemberForm extends MemberForm { 

	public function initialize(Member $member, $options, $edit = false) { 
		
		parent::initialize($member, $options, $edit);

		$value = $this->get('username');
		$value->addValidator( new DuplicateDatabaseEntryValidator('username'));

		$value = $this->get('email');
		$value->addValidator(new DuplicateDatabaseEntryValidator('email'));
	}
}
