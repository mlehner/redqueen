<?php

class sfValidatorUsername extends sfValidatorString
{
    public function doClean($value)
    {
        $clean = parent::doClean($value);
        $clean = strtolower($clean);

        if (!preg_match('/^[a-z][a-z0-9]*$/', $clean))
            throw new sfValidatorError($this, 'invalid', array('value' => $value));

        if ($person = Lookup::person($clean))
            throw new sfValidatorError($this, 'exists', array('value' => $value));
        
        return $clean;
    }

    public function configure($options = array(), $messages = array())
    {
        $this->addMessage('exists', 'Username (%value%) already exists');
    }
}
