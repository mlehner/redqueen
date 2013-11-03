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

		var_dump($member->getCreatedAt());die;
        $form = $this->view->form = new NewMemberForm($member, array());

        if ($this->request->isPost()) {
            $form->bind($_POST, $member);

            if ($form->isValid()) {
                $member->password = $this->security->hash($member->password);
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
