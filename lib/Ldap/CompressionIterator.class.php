<?php

class Ldap_CompressionIterator extends Zend_Ldap_Collection
{
    static public function compressEntry(array $data)
    {
         $new_data = array();

        foreach ($data as $key => $attr)
        {
            if (is_array($attr) && count($attr) <= 1)
                $new_attr = $attr[0];
            else
                $new_attr = $attr;

            $new_data[$key] = $new_attr;
        }

        return $new_data;       
    }

    protected function _createEntry(array $data)
    {
        return self::compressEntry($data);
    }
}
