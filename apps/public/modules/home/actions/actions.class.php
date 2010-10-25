<?php

/**
 * home actions.
 *
 * @package    hs
 * @subpackage home
 * @author     synace
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class homeActions extends sfActions
{
 /**
  * Welcome screen
  */
  public function executeIndex(sfWebRequest $request) {
    // first request when the remote computer boots sets the door, or defaults
    // @TODO fix session length to infinite to keep door value
    $door = $this->getRequestParameter('door');
    if ($door) {
      $this->getUser()->setDoor($door);
      $this->redirect('@homepage');
    }
    if (!$this->getUser()->getDoor()) {
      $this->forward('home', 'door');
    }

    $rfid = $this->getRequestParameter('rfid');
    if ($rfid) {
      $this->getUser()->setRfid(Tag::decrypt($rfid));
      $this->redirect('@rfid');
    } else {
      $this->getUser()->unsetRfid();
    }

    $this->getUser()->unsetUsername();

    $this->getUser()->setAction(myUser::ACTION_OPEN);
  }

  /**
   * Select door manually.
   */
  public function executeDoor(sfWebRequest $request) {
    $this->doors = array();
    foreach(Door::$identifiers as $door => $identifier) {
      $this->doors[$door] = $door;
    }
    return sfView::ERROR;
  }

  /**
   * An RFID tag was swiped and the client was pushed to this url, use the user attribute to determine what we'll do
   */
  public function executeRfid(sfWebRequest $request) {
    $this->rfid = $this->getUser()->getRfid();
    if (!$this->rfid) {
      $this->redirect('@homepage');
    }

    switch($this->getUser()->getAction()) {
      case myUser::ACTION_REGISTER:
        if(Tag::get($this->rfid)) {
          return sfView::ERROR.'Exists';
        }
        break;

      case myUser::ACTION_OPEN:
      default:
        if (!($tag = Tag::get($this->rfid))) {
          sfContext::getInstance()->getLogger()->alert(sprintf('Invalid RFID! (rfid = %s)', $this->rfid));
          return sfView::ERROR;
	}

//* @DEBUG
        Door::open($this->getUser()->getDoor());
        $this->getUser()->setFlash('DOOR_OPEN', true);

        $person = $tag->getPerson();

        $person->welcome();
        $this->getUser()->setUsername($person->getNickname());
        
        $this->redirect('@open');
//*/
        break;
    }

    $this->forward('home', 'pin');
  }

  /**
   * Enter pin for Provided RFID tag, @TODO timeout
   */
  public function executePin(sfWebRequest $request) {
    $this->error = false;
  
    $this->rfid = $this->getUser()->getRfid();
    if (!$this->rfid) {
      $this->redirect('@homepage');
    }

    $pin = $this->getRequestParameter('pin');

    switch($this->getUser()->getAction()) {
      case myUser::ACTION_REGISTER:
        $this->username = $this->getUser()->getUsername();
        if (!$this->username) {
          $this->redirect('@register');
        }

        if (!$pin) {
          return sfView::ERROR;
        }

        $person = Lookup::person($this->username);
        $person->addTag($this->rfid, $pin);

        $this->getUser()->setFlash('REGISTER_COMPLETE', true);
        $this->redirect('@register');
        break;

      case myUser::ACTION_OPEN:
      default:
        if (!$pin) {
          return sfView::ERROR;
        }

        $tag = Tag::get($this->rfid);
        if (!$tag || !$tag->checkPin($pin)) {
          $this->error = true;
          return sfView::ERROR;
        }

        Door::open($this->getUser()->getDoor());
        $this->getUser()->setFlash('DOOR_OPEN', true);

        $person = $tag->getPerson();
        $person->welcome();
        $this->getUser()->setUsername($person->getNickname());

        $this->redirect('@open');
        break;
    }
  }

  /**
   * Perform a login, using username & password
   */
  public function executeLogin(sfWebRequest $request) {
    $this->error = false;
    $username = $this->getRequestParameter('username');
    $password = $this->getRequestParameter('password');

    if (!$username || !$password) {
      $this->getUser()->unsetUsername();
      return sfView::ERROR;
    }

    $person = Person::get($username);
    if (!$person || !$person->checkPassword($password)) {
      $this->error = true;
      return sfView::ERROR;
    }

    switch($this->getUser()->getAction()) {
      case myUser::ACTION_REGISTER:
        $this->getUser()->setUsername($username);
        $this->forward('home', 'register');
        break;

      case myUser::ACTION_OPEN:
      default:
        Door::open($this->getUser()->getDoor());
        $this->getUser()->setFlash('DOOR_OPEN', true);

	$person->welcome();
        $this->getUser()->setUsername($person->getNickname());
        
        $this->redirect('@open');
        break;
    }
  }

  /**
   * Register a new tag
   */
  public function executeRegister(sfWebRequest $request) {
    // if completed registration, show the completion result
    $complete = $this->getUser()->getFlash('REGISTER_COMPLETE');
    if ($complete) {
      $this->getUser()->setFlash('REGISTER_COMPLETE', false);
      $this->getUser()->unsetUsername();
      $this->getUser()->unsetRfid();
      $this->getUser()->unsetAction();
      return sfView::SUCCESS;
    }

    // if logged in, store username & wait for swipe, then send to pin pad
    if ($this->getUser()->getUsername()) {
      return sfView::ERROR;
    }

    // if not logged in, kick to login page to start register process
    $this->getUser()->setAction(myUser::ACTION_REGISTER);
    $this->redirect('@login');
  }

  /**
   * Open the door
   */
  public function executeOpen(sfWebRequest $request) {
    if (!$this->getUser()->getFlash('DOOR_OPEN')) {
      $this->redirect('@homepage');
    }

    $this->username = $this->getUser()->getUsername();

    $this->getUser()->setFlash('DOOR_OPEN', false);
    $this->getUser()->unsetUsername();
    $this->getUser()->unsetRfid();
    $this->getUser()->unsetAction();
  }
}
