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

		var_dump($member->getCards());die;
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

	public function cardsNewAction( $member_id)
	{

			$member = Member::findFirstById($member_id);

			$card = new Card();

			$form = $this->view->form = new CardForm($card, array());

			if ($this->request->isPost()){
				
				$form->bind($_POST, $card);
				if ($form->isValid()){
					$card->setMemberId($member_id);
					var_dump($card);die;
				}
			}
	}
}
