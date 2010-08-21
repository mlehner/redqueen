<?php

class Door {

  /**
   * hard coded. referenced by identifier by remote system.
   *
   * bits are 2^x, ex: 2^0 = 1 = first bit in trigger
   */
  static $identifiers = array(
    1 => 'MAIN',
    2 => 'CONFERENCE_EXTERIOR',
    3 => 'CONFERENCE_INTERIOR',
    4 => 'QUIET',
    5 => 'KITCHEN',
    6 => 'WAREHOUSE_EXTERIOR'
  );
  
  const DEFAULT_DOOR = 'MAIN';

  static function open($door) {
    $door_id = array_search($door, self::$identifiers);
    if (!$door_id) {
      return false;
    }

    $bit = $door_id - 1;

    $script = realpath(dirname(__FILE__) . '/../control/trigger');
    $address = '0x378';
    $value = pow(2, $bit);
    $duration = 5;
    $pause = 2; // added 2 seconds to wait for twitter

    @exec($script . ' ' . $address . ' ' . $value . ' ' . $duration . ' ' . $pause . ' > /dev/null &');

    return true;
  }
}
