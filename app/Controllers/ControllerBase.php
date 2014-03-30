<?php

use Phalcon\Mvc\Controller;
use Phalcon\Dispatcher;

class ControllerBase extends Controller
{
    public function beforeExecuteRoute(Dispatcher $dispatcher) {
        $controllerName = $dispatcher->getControllerName();
        $actionName = $dispatcher->getActionName();

        // allow login without authentication
        if ($controllerName == 'security' && $actionName == 'login') {
            return true;
        }

        $token = $this->session->get('token');
        if (!is_array($token)) {
            $this->response->redirect('security/login');

            return false;
        }

        return true;
    }
}
