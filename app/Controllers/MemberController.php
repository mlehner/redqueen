<?php
use \Phalcon\Http\Response;

class MemberController extends ControllerBase
{
    public function indexAction()
    {
        $this->view->members = Member::find();
    }

    public function newAction()
    {
        $member = new Member();

        $form = $this->view->form = new NewMemberForm($member, array());

        if ($this->request->isPost()) {
            $form->bind($_POST, $member);
			
            if ($form->isValid()) {
                $member->setPassword($this->security->hash($member->getPassword()))
				->setCreatedAt(new \DateTime('now'));


                $member->save();

				var_dump($member);die;

				$response = new Response();

				$this->flash->success(sprintf('Member %s successfully created', $member->getUsername()));
				$this->view->disable();
				return $response->redirect('member');
            } 
        }
    }


    public function editAction($member_id)
    {
        $member = Member::findFirstById($member_id);
		$member->setPassword('');
        $form = $this->view->form = new MemberForm($member, array());

        if ($this->request->isPost()) {
            $form->bind($_POST, $member);

            if ($form->isValid()) {
                $member->update();

				$response = new Response();
				return $response->redirect('member');
            }
        }
    }

	public function cardsAction($sub_route, $member_id)
	{

		if ($sub_route == 'new') { 
			var_Dump($member_id);
			$member = Member::findFirstById($member_id);

			var_Dump($member);
			die('hi');
		}
	}
}
