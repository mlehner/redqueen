<?php

class Person {
  public $dn;
  public $name;
  public $username;

  public function __construct($dn, $name, $username) {
    $this->dn = $dn;
    $this->name = $name;
    $this->username = $username;
  }

  static function create($first_name, $last_name, $nickname, $email, $username, $password)
  {
    try
    {
        $entry = array();
        Zend_Ldap_Attribute::setAttribute($entry, 'objectClass', array('inetOrgPerson', 'posixAccount'));
        Zend_Ldap_Attribute::setAttribute($entry, 'uid', $username);
        Zend_Ldap_Attribute::setPassword($entry, $password, Zend_Ldap_Attribute::PASSWORD_HASH_SHA);
        Zend_Ldap_Attribute::setAttribute($entry, 'cn', sprintf('%s %s', $first_name, $last_name));
        Zend_Ldap_Attribute::setAttribute($entry, 'givenName', $first_name);
        Zend_Ldap_Attribute::setAttribute($entry, 'surname', $last_name);
        Zend_Ldap_Attribute::setAttribute($entry, 'displayName', $nickname);
        Zend_Ldap_Attribute::setAttribute($entry, 'mail', $email);
        Zend_Ldap_Attribute::setAttribute($entry, 'uidNumber', '10000');
        Zend_Ldap_Attribute::setAttribute($entry, 'gidNumber', '100');
        Zend_Ldap_Attribute::setAttribute($entry, 'homeDirectory', sprintf('/home/%s', $username));
	Zend_Ldap_Attribute::setAttribute($entry, 'loginShell', '/bin/bash');

        $ldap = Lookup::ldap();
        $ldap->add(sprintf('uid=%s,%s', $username, sfConfig::get('app_ldap_base_dn')), $entry);
        return true;
    } catch (Zend_Ldap_Exception $e) {
    }

    return false;
  }

  static function get($rfid) {
    return Lookup::person($rfid);
  }
  
  public function checkPassword($password) {
    $options = array(
		'host' => sfConfig::get('app_ldap_host'),
		'username' => $this->dn,
		'password' => $password,
		'useStartTls' => sfConfig::get('app_ldap_use_tls')	
	);   
    $ldap = new Zend_Ldap($options);

    try {
      $ldap->bind();
      return ($ldap->getLastErrorCode() == 0); 
    } catch(Zend_Ldap_Exception $e) {
    }
    return false;
  }

  public function changePassword($old_password, $new_password)
  {
    $options = array(
        'host' => sfConfig::get('app_ldap_host'),
        'username' => $this->dn,
        'password' => $old_password,
        'useStartTls' => sfConfig::get('app_ldap_use_tls'),
        'baseDn' => sfConfig::get('app_ldap_base_dn')
    );

    $ldap = new Zend_Ldap($options);

    try {
        $ldap->bind();

        $node = $ldap->getNode($this->dn);
        $node->attachLdap($ldap);

        $attr = $node->getAttribute('userPassword');
        $password_hash = $attr[0];

        if (substr($password_hash, 0, 6) == '{SASL}')
            return false;

        $node->setPasswordAttribute($new_password, Zend_Ldap_Attribute::PASSWORD_HASH_SHA);

        $node->update();

        return true;
    } catch(Zend_Ldap_Exception $e) {
    }

    return false;
  }

  public function addTag($rfid, $pin) {
    $ldap = Lookup::ldap();
    $uid = 'RFID:'.$rfid;
    $dn = 'uid='.$uid.','.$this->dn;
    if ($ldap->exists($dn)) {
      return false;
    }
    try {
      $entry = array();
      Zend_Ldap_Attribute::setAttribute($entry, 'uid', $uid);
      Zend_Ldap_Attribute::setPassword($entry, $pin, Zend_Ldap_Attribute::PASSWORD_HASH_SHA);
      Zend_Ldap_Attribute::setAttribute($entry, 'objectClass', array('account', 'simpleSecurityObject', 'top'));
      $ldap->add($dn, $entry);
      return true;
    } catch (Zend_Ldap_Exception $e) {
      return false;
    }
  }

  public function welcome() {
    $Twitter = Lookup::twitter();
    // @TODO: only update user once per half hour
    try {
      $result = $Twitter->updateStatus($this->username . ' has entered the hackerspace.');
      return true;
    } catch (Arc90_Service_Twitter_Exception $e) {
    }
    return false;
  }
}
