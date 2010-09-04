<?php

class myUser extends sfBasicSecurityUser
{
  const ACTION_OPEN = 'OPEN';
  const ACTION_REGISTER = 'REGISTER';

  public function getAction() {
    return $this->getAttribute('DESIRED_ACTION', self::ACTION_OPEN);
  }
  public function setAction($action) {
    $this->setAttribute('DESIRED_ACTION', $action);
  }
  public function unsetAction() {
    $this->setAttribute('DESIRED_ACTION', null);
  }

  public function getDoor() {
    return $this->getAttribute('DESIRED_DOOR', Door::$identifiers[ Door::DEFAULT_DOOR ]);
  }
  public function setDoor($door) {
    if ($door && in_array($door, Door::$identifiers)) {
      $this->setAttribute('DESIRED_DOOR', $door);
    }
  }
  public function unsetDoor() {
    $this->setAttribute('DESIRED_DOOR', null);
  }

  public function getRfid() {
    return $this->getAttribute('RFID', null);
  }
  public function setRfid($rfid) {
    $this->setAttribute('RFID', $rfid);
  }
  public function unsetRfid() {
    $this->setAttribute('RFID', null);
  }

  public function getUsername() {
    return $this->getAttribute('USERNAME', null);
  }
  public function setUsername($rfid) {
    $this->setAttribute('USERNAME', $rfid);
  }
  public function unsetUsername() {
    $this->setAttribute('USERNAME', null);
  }
}
