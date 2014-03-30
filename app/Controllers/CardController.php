<?php

use \Phalcon\Http\Response;

class CardController extends ControllerBase { 
    public function indexAction() {
        $cards = Cards::find();

        $this->view->cards = $cards;
    }

    public function editAction($card_id) {
        $card = Cards::findFirstById($card_id);

        if (!($card instanceof Cards)) {
            // 404
            $this->response->setStatusCode(404, "Not Found");
            $this->response->setContent("Card Not Found");

            return;
        }

        $form = new CardForm($card, array());

        if ($this->request->isPost()) {
            $form->bind($this->request->getPost(), $card);
            if ($form->isValid()){
                $card->setUpdatedAt(new \DateTime('now'));

                $card->save();

                return $this->response->redirect('card');
            }
        }

        $this->view->form = $form;
    }

    public function newAction($member_id) {
        $member = Members::findFirstById($member_id);

        if (!($member instanceof Members)) {
            // 404
            $this->response->setStatusCode(404, "Not Found");
            $this->response->setContent("Member Not Found");

            return;
        }

        $card = new Cards();

        $form = new CardForm($card, array());

        if ($this->request->isPost()){
            $form->bind($this->request->getPost(), $card);
            if ($form->isValid()){
                $card->setMemberId($member_id)
                    ->setCreatedAt(new \DateTime('now'));

                $card->save();

                return $this->response->redirect('card');
            }
        }

        $this->view->form = $form;
    }

}
