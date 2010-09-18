<?php

class Tag {

    /**
     * Distinquished Name of Tag
     */
    public $dn;

    /**
     * Person this tag belongs too
     */
    public $person;

    /**
     * Contains the RFID tag identifier
     * prefixed with RFID:
     */
    public $uid;

    /**
     * Hash pin for authenticating tag
     */
    public $hashed_pin;

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
        $fields = array('dn', 'uid');

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

        #$this->_fixDoors();
    }

    public function getRFID()
    {
        return substr($this->uid, 6);
    }

    static function get($rfid) {
        return Lookup::tag($rfid);
    }

    static function getAll($base_dn = null)
    {
        $ldap = Lookup::ldap();

        $tags = array();
        
        $collection = $ldap->search('(objectClass=simpleSecurityObject)', $base_dn == null ? sfConfig::get('app_ldap_members_dn') : $base_dn, Zend_Ldap::SEARCH_SCOPE_SUB, array(), null, 'Ldap_CompressionIterator');

        foreach($collection as $entry)
        {
            if (array_key_exists('uid', $entry) && substr($entry['uid'], 0, 5) == 'RFID:')
                $tags[] = new Tag($entry);
        }

        return $tags;
    }

    static function getAllForPerson($dn)
    {
        if ($dn instanceof Person)
        {
            $dn = $dn->getDN();
        }

        return Tag::getAll($dn);
    }

    public function getDN()
    {
        return $this->dn;
    }

    public function getDoors()
    {
        return Door::getAllForTag($this);
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
