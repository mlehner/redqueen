<?php

class Member extends \Phalcon\Mvc\Model 
{
    /**
     *
     * @Primary
     * @Identity
     * @Column(type="integer", nullable=false)
     */
    public $id;

    /**
     * @Column(type="string", length=255)
     */
    public $name;

    /*
     * @Column(type="string", length=255)
     */
    public $username;

    /*
     * @Column(type="stirng", length=255)
     */
    public $email;

    /*
     * @Column(type="string", length=255)
     */
    public $password;
}
