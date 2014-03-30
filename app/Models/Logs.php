<?php

class Logs extends \Phalcon\Mvc\Model
{
    /**
     * @Primary
     * @Identity
     * @Column(type="integer", nullable=false)
     */
    protected $id;

    /**
     * @Column(type="integer")
     */
    protected $card_id;

    /**
     * @Column(type="string", length=6)
     */
    protected $code;

    /**
     * @Column(type="boolean")
     */
    protected $valid_pin;

    /**
     * @Column(type="string")
     */
    protected $datetime;

    public function getSource() {
        return "log";
    }

    public function initialize() {
        $this->belongsTo("card_id", "Cards", "id");
    }

    public function getId() {
        return $this->id;
    }

    public function getCode() {
        return $this->code;
    }

    public function getDatetime() {
        return $this->datetime;
    }

    public function wasValidPin() {
        return (bool)$this->valid_pin;
    }

    public function getMemberName() {
        if ($this->Cards && $this->Cards->Members) {
            return $this->Cards->Members->getName();
        }
    }
}
