<?php

$router = new Phalcon\Mvc\Router();

$router->add("/member", array(
	'controller' => 'member',
	'action' => 'index'
));

$router->add("/member/new", array( 
	'controller' => 'member', 
	'action' => 'new'
));

$router->add("/member/edit/{memeber_id}", array(
	'controller' => 'member', 
	'action' => 'edit'
));

$router->add("/member/{member_id}/card/new", array(
	'controller' => 'card', 
	'action' => 'new'
));
