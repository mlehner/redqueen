<?php

/**
 * account actions.
 *
 * @package    hs
 * @subpackage account
 * @author     Matt Lehner 
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class accountActions extends sfActions
{
    /**
    * Executes index action
    *
    * @param sfRequest $request A request object
    */
    public function executeIndex(sfWebRequest $request)
    {
    }

    public function executeChangePassword(sfWebRequest $request)
    {
        $form = new ChangePasswordForm();

        $form->embedForm('login', new LoginForm());

        if ($request->isMethod('POST'))
        {
            $form->bind($request->getParameter('change_passwd'));

            if ($form->isValid())
            {
                $login = $form->getValue('login');

                if ($person = $this->_validateLogin($login['username'], $login['password']))
                {
                    if ($person->changePassword($login['password'], $form->getValue('new_passwd')))
                    {
                        $this->getUser()->setFlash('notice', 'Password changed!');
                    }
                    else
                    {
                        $this->getUser()->setFlash('error', 'Failed to change password.');
                    }
                }
                else
                {
                    $this->getUser()->setFlash('error', 'Login failed!');
                }
            }
        }

        $this->form = $form;
    }

    public function executeNew(sfWebRequest $request)
    {
        $form = new NewMemberForm();

        $form->embedForm('login', new LoginForm());

        if ($request->isMethod('POST'))
        {
            $form->bind($request->getParameter('new_member'));
            
            if ($form->isValid())
            {
                $login = $form->getValue('login');

                if (in_array($login['username'], array('jerel', 'mlehner', 'm')))
                {
                    if ($person = $this->_validateLogin($login['username'], $login['password']))
                    {
                        if (Person::create($form->getValue('first_name'), $form->getValue('last_name'), $form->getValue('nickname'), $form->getValue('email'), $form->getValue('username'), $form->getValue('password')))
                        {
                            $this->getUser()->setFlash('notice', 'New member has been added successfully!');
                        }
                        else
                        {
                            $this->getUser()->setFlash('error', 'Failed to add new member to LDAP!');
                        }
                    }
                    else
                    {
                        $this->getUser()->setFlash('error', 'Login failed!');
                    }
                }
                else
                {
                    $this->getUser()->setFlash('error', 'Only Administrators can add new members');
                }
            }
        }

        $this->form = $form;
    }

    private function _validateLogin($username, $password)
    {
        $person = Lookup::person($username);

        if ($person === false)
            return false;

        if ($person->checkPassword($password))
            return $person;

        return false;
    }
}
