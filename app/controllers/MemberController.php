<?php

/*
 * @RoutePrefix("/members")
 */
class MemberController extends ControllerBase
{
    /*
     * @Route("/", methods={"GET"}, name="members_list")
     */
    public function indexAction()
    {
        $this->view->members = Member::find();
    }

    /*
     * @Route("/new", methods={"POST","GET"}, name="members_new")
     */
    public function newAction()
    {
        $member = new Member();
        $form = $this->view->form = new MemberForm($member, array());

        if ($this->request->isPost()) {
            $form->bind($_POST, $member);

            if ($form->isValid()) {
                $member->password = $this->security->hash($member->password);
                
                $member->save();
                
                
            } 
        }
    }


    /*
     * @Route("/edit/{member_id}", methods={"POST","GET"}, name="members_new")
     */
    public function editAction($member_id)
    {
        $member = Member::findFirstByIdentifier($member_id);

        $form = $this->view->form = new MemberForm($member, array());

        if ($this->request->isPost()) {
            $form->bind($_POST, $member);

            if ($form->isValid()) {
                $member->save();
            }
        }
    }
}
