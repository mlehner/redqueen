<?php

use \Phalcon\Http\Response;

class CardController extends ControllerBase { 

    public function newAction($member_id) {
        $member = Members::findFirstById($member_id);
        $card = new Cards();

        $form = $this->view->form = new CardForm($card, array());

        if ($this->request->isPost()){
            $form->bind($_POST, $card);
            if ($form->isValid()){
                $card->setMemberId($member_id)
                    ->setCreatedAt(new \DateTime('now'));

                $card->save();

                $response = new Response();

                return $response->redirect('member');
            }
        }
    }

}
