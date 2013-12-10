<?php

$router = new Phalcon\Mvc\Router();

$router->add("/dashboard", array(
    'controller' => 'index',
    'action' => 'index'
))->setName('dashboard');

$router->add("/log", array(
    'controller' => 'index',
    'action' => 'log'
))->setName('log_index');

$router->add("/member", array(
    'controller' => 'member',
    'action' => 'index'
))->setName('member_index');

$router->add("/member/new", array( 
    'controller' => 'member', 
    'action' => 'new'
))->setName('member_new');

$router->add("/member/edit/{memeber_id}", array(
    'controller' => 'member', 
    'action' => 'edit'
))->setName('member_edit');

$router->add("/member/{member_id}/card/new", array(
    'controller' => 'card', 
    'action' => 'new'
))->setName('member_new');
