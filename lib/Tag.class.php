<?php

class Tag {
  public $dn;
  public $person;
  public $rfid;
  public $hashed_pin;

  public function __construct($dn, $person, $rfid, $hashed_pin) {
    $this->dn = $dn;
    $this->person = $person;
    $this->rfid = $rfid;
    $this->hashed_pin = $hashed_pin;
  }

  static function get($rfid) {
    return Lookup::tag($rfid);
  }

  public function checkPin($pin) {
    $hashed_pin = Zend_Ldap_Attribute::createPassword($pin, Zend_Ldap_Attribute::PASSWORD_HASH_SHA);
    return ($hashed_pin == $this->hashed_pin) ? true : false;
  }

  public function delete() {
    $ldap = Lookup::ldap();
    $ldap->delete($this->dn);
  }

  public function updatePin($pin) {
    $ldap = Lookup::ldap();
    try {
      $entry = $ldap->getEntry($this->dn);
      Zend_Ldap_Attribute::setPassword($entry, $pin, Zend_Ldap_Attribute::PASSWORD_HASH_SHA);
      $ldap->update($this->dn, $entry);
      return true;
    } catch (Zend_Ldap_Exception $e) {
      return false;
    }
  }

  static function decrypt($encrypted_text) {
    static $handle;
    if (!isset($handle)) {
      $key = sfConfig::get('app_encrypt_key');
      $algorithm = MCRYPT_BLOWFISH;
      $mode = MCRYPT_MODE_ECB;
      $handle = mcrypt_module_open($algorithm, '', $mode, '');
      $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($handle), MCRYPT_RAND);
      $expected_key_size = mcrypt_enc_get_key_size($handle);
      $key = substr(md5($key), 0, $expected_key_size);
      mcrypt_generic_init($handle, $key, $iv);
    }
    return rtrim(mdecrypt_generic($handle, pack("H*", $encrypted_text)), "\0");
  }
}
