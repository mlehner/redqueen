<?php

class Card extends \Phalcon\Mvc\Model
{

    /*
     * 
     * @Primary
     * @Identity
     * @Column(type="integer", nullable=false
     */
    public $id;

    /*
     * @Column(type="integer", nullale=false)
     */
    public $member_id;

    /*
     * @Column(type="string", length=6)
     */
    public $code;

    /*
     * @Column(type="string", length=32)
     */
    public $pin;
}
