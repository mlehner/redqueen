<?php

class MemberController extends ControllerBase
{
    public function indexAction()
    {
        $this->view->members = Member::find();
    }

    public function newAction()
    {
        $member = new Member();
        $form = $this->view->form = new MemberForm($member, array());

        if ($this->request->isPost()) {
            $form->bind($_POST, $member);

            if ($form->isValid()) {
                $member->save();
                
                
            } 
        }
    }
}
