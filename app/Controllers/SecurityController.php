<?php

class SecurityController extends ControllerBase {
    public function loginAction() {
        $form  = new LoginForm;

        if ($this->request->isPost()) {
            try {
                if ($form->isValid($this->request->getPost())) {
                    $member = Members::findFirstByEmail($this->request->getPost('email'));

                    if (!($member instanceof Members)) {
                        // Failed login
                        throw new Exception('Incorrect Username or Password');
                    }

                    if ($this->security->checkHash($this->request->getPost('password'), $member->getPassword())) {
                        // Success!
                        $this->session->set('token', array(
                            'id' => $member->getId(),
                            'email' => $member->getEmail(),
                            'ip_address' => $this->request->getClientAddress(),
                        ));

                        $this->session->set('last_seen', time());

                        $this->response->redirect('dashboard');
                    } else {
                        // Failed login
                        throw new Exception('Incorrect Username or Password');
                    }
                } else {
                    $this->flash->error('Invalid form.');
                }
            } catch (Exception $e) {
                $this->flash->error($e->getMessage());
            }
        }

        $this->view->form = $form;
    }

    public function logoutAction() {
        $this->session->destroy();

        $this->response->redirect('security/login');
    }
}
