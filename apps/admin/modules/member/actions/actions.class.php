<?php

/**
 * member actions.
 *
 * @package    hs
 * @subpackage member
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class memberActions extends sfActions
{
    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request)
    {
        $this->forward('member', 'list');
    }


    public function executeList(sfWebRequest $request)
    {
        $this->members = Person::getAll();
    }
}
