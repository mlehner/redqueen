<?php

class IndexController extends ControllerBase
{

    public function indexAction()
    {

    }

    public function logAction()
    {
        $this->view->logs = Logs::find(array('limit' => 10, 'order' => 'datetime DESC'));
    }
}

