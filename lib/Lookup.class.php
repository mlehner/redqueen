<?php

class Lookup {
  static function twitter() {
    static $twitter;
    if (!$twitter) {
      require_once(sfConfig::get('sf_root_dir').'/vendor/Arc90/Service/Twitter.php');
      $twitter = new Arc90_Service_Twitter(sfConfig::get('app_twitter_username'), sfConfig::get('app_twitter_password'));
    }
    return $twitter;
  }

  /**
   * @return Zend_Ldap
   */
  static function ldap() {
    static $ldap;
    if (!$ldap) {
      $options = array(
          'host'              => sfConfig::get('app_ldap_host'),
	  'useStartTls'       => sfConfig::get('app_ldap_use_tls'),
          'username'          => sfConfig::get('app_ldap_admin_dn'),
          'password'          => sfConfig::get('app_ldap_admin_password'),
          'bindRequiresDn'    => true,
          'baseDn'            => sfConfig::get('app_ldap_base_dn'),
      );
      $ldap = new Zend_Ldap($options);
      $ldap->bind();
    }
    return $ldap;
  }

  /**
   * inetOrgPerson
   * 
   * @param $username
   * @return Person
   */
  static function person($username) {
    $ldap = self::ldap();
    try {
      $result = $ldap->search('(uid='.$username.')', sfConfig::get('app_ldap_base_dn'));
      if ($result && $data = $result->getFirst()) {
        $person = $ldap->getNode($data['dn']);
        return new Person($person->getAttribute('dn'), $person->getAttribute('cn', 0), $person->getAttribute('uid', 0));
      }
    } catch (Zend_Ldap_Exception $e) {
      return false;
    }
    return false;
  }

  /**
   * simpleSecurityObject, child of inetOrgPerson
   * 
   * @param $username
   * @return Person
   */
  static function tag($rfid) {
    $ldap = self::ldap();
    try {
      $result = $ldap->search('(uid=RFID:'.$rfid.')', sfconfig::get('app_ldap_base_dn'));
      if ($result && $data = $result->getFirst()) {
        $tag = $ldap->getNode($data['dn']);
        $person = $tag->getParent($ldap);
        $person = new Person($person->getAttribute('dn'), $person->getAttribute('cn', 0), $person->getAttribute('uid', 0));
        return new Tag($tag->getAttribute('dn', 0), $person, preg_replace('#^RFID:#', '', $tag->getAttribute('uid', 0)), $tag->getAttribute('userPassword', 0));
      }
    } catch (Zend_Ldap_Exception $e) {
      return false;
    }
    return false;
  }
}
