<?php
use \Phalcon\Http\Response;

class MemberController extends ControllerBase
{
    public function indexAction()
    {
        $members = Members::find();
        $this->view->members = $members;
    }

    public function quickAddAction()
    {
        $defaults = new stdclass();
        $defaults->code = $this->request->getQuery('code');

        $form = $this->view->form = new QuickAddForm($defaults);

        if ($this->request->isPost()) {

            if ($form->isValid($this->request->getPost())) {
                $member = new Members();
                $member->setCreatedAt(new \DateTime('now'));
                $member->setUpdatedAt(new \DateTime('now'));
                $member->setEmail($this->request->getPost('email'));
                $member->setName($this->request->getPost('name'));

                $member->save();

                $card = new Cards();
                $card->setCreatedAt(new \DateTime('now'));
                $card->setCode($this->request->getPost('code'));
                $card->setPin($this->request->getPost('pin'));
                $card->members = $member;

                $card->save();

                $response = new Response();

                $this->flash->success(sprintf('Member %s successfully created', $member->getName()));
                $this->view->disable();
                return $response->redirect('member');
            } 
        }
    }

    public function newAction()
    {
        $member = new Members();

        $form = $this->view->form = new NewMemberForm($member, array());

        if ($this->request->isPost()) {
            $form->bind($_POST, $member);

            if ($form->isValid()) {
                $member->setPassword($this->security->hash($member->getPassword()))
                    ->setCreatedAt(new \DateTime('now'));

                $member->save();

                $response = new Response();

                $this->flash->success(sprintf('Member %s successfully created', $member->getUsername()));
                $this->view->disable();
                return $response->redirect('member');
            } 
        }
    }


    public function editAction($member_id)
    {
        $member = Members::findFirstById($member_id);

        $member->setPassword('');
        $form = $this->view->form = new MemberForm($member, array());

        if ($this->request->isPost()) {
            $form->bind($_POST, $member);

            if ($form->isValid()) {
                $member->setUpdatedAt(new \DateTime('now'));
                $member->update();

                $response = new Response();
                return $response->redirect('member');
            }
        }
    }

}

