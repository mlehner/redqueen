<?php

class Person {

  /**
   * Distinquished Name of Person (for LDAP lookup)
   */
  public $dn;

  /**
   * Username for login
   */
  public $uid;
  
  /**
   * Primary contact email
   */
  public $mail;
  
  /**
   * Given Name (first name)
   */
  public $givenName;

  /**
   * Sur Name (last name)
   */
  public $sn;

  /**
   * Common Name (first and last)
   */
  public $cn;

  /**
   * Nickname
   */
  public $displayName;

  /**
   * UID, GID, Home directory and Login shell for *nix/bsd based systems
   */
  public $uidNumber;
  public $gidNumber;
  public $homeDirectory;
  public $loginShell; 
 
    /**
     * Did the data pass validation?
     */
    protected $_valid;

    protected $_dirtyFields;

    public function __construct(array $data = null)
    {
        $this->_valid = true;
        $this->_dirtyFields = array();

        if ($data)
            $this->hydrate($data);
    }

    protected function hydrate(array $data)
    {
        $fields = array('dn', 'uid', 'mail', 'givenName', 'sn', 'cn', 'displayName', 'uidNumber', 'gidNumber', 'homeDirectory', 'loginShell');

        foreach ($fields as $field_name)
        {
            $data_key_name = strtolower($field_name);
            if (array_key_exists($data_key_name, $data))
            {
                $this->$field_name = $data[ $data_key_name ];

                // All the fields we care about right now should not contain multiple values
                if (is_array($data[ $data_key_name ]))
                {
                    $this->_valid = false;
                }
            }
            else
            {
                $this->$field_name = null;
            }
        }

        $this->_fixName();
    }

    protected function _fixName()
    {
        if (($this->sn == null || $this->givenName == null) && $this->cn != null)
        {
            list($givenName, $surName) = explode(' ', $this->cn, 2);

            if ($givenName != null)
                $this->setGivenName($givenName);
            else
                $this->setGivenName($this->uid);

            if ($surName != null)
                $this->setSurName($surName);
            else
                $this->setSurName(' ');
        }

        if ($this->displayName == null)
        {
            $this->setNickname($this->uid);
        }

        // save it!
        $this->save();
    }

    public function getDN()
    {
        return $this->dn;
    }

    public function setGivenName($givenName)
    {
        $this->_setField('givenName', $givenName);
        $this->_setField('cn', sprintf('%s %s', $givenName, $this->sn));
    }

    public function setSurName($surName)
    {
        $this->_setField('sn', $surName);
        $this->_setField('cn', sprintf('%s %s', $this->givenName, $surName));
    }

    public function getFullName()
    {
        return $this->cn;
    }

    public function setNickname($nickname)
    {
        $this->_setField('displayName', $nickname);
    }

    public function getNickname()
    {
        return $this->displayName;
    }

    public function getUsername()
    {
        return $this->uid;
    }

    protected function _setField($field, $value)
    {
        $this->$field = $value;

        if (!in_array($field, $this->_dirtyFields))
            $this->_dirtyFields[] = $field;
    }

    public function isValid()
    {
        return $this->_valid;
    }

    static function getAll()
    {
        $ldap = Lookup::ldap();

        $people = array();
        
        $collection = $ldap->search('(objectClass=inetOrgPerson)', sfConfig::get('app_ldap_members_dn'), Zend_Ldap::SEARCH_SCOPE_ONE, array(), null, 'Ldap_CompressionIterator');

        foreach($collection as $entry)
        {
            $people[] = new Person($entry);
        }

        return $people;
    }

    function getTags()
    {
        return Tag::getAllForPerson($this);
    }

    public function save()
    {
        if (!count($this->_dirtyFields)) return true;
        
        //try
        //{
            $entry = array();
            foreach ($this->_dirtyFields as $field)
            {
                Zend_Ldap_Attribute::setAttribute($entry, $field, $this->$field);
            }
            //Zend_Ldap_Attribute::setPassword($entry, $password, Zend_Ldap_Attribute::PASSWORD_HASH_SHA);
            
            $ldap = Lookup::ldap();
            $ldap->update($this->dn, $entry);
            $this->_dirtyFields = array();

            return true;
        //} catch (Zend_Ldap_Exception $e) {
        //}

        return false;
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
        $ldap->add(sprintf('uid=%s,%s', $username, sfConfig::get('app_ldap_members_dn')), $entry);
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
        'baseDn' => sfConfig::get('app_ldap_members_dn')
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
      $result = $Twitter->updateStatus($this->uid . ' has entered the hackerspace.');
      return true;
    } catch (Arc90_Service_Twitter_Exception $e) {
    }
    return false;
  }
}
