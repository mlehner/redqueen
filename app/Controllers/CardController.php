<?php

class CardController extends ControllerBase { 

	public function indexAction() {
		$this->view->cards = Card::find();
	}

	public function newAction() { 
	}

}
