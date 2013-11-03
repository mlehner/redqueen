<?php

class Card extends \Phalcon\Mvc\Model
{
    /*
     * @Primary
     * @Identity
     * @Column(type="integer", nullable=false
     */
    protected $id;

    /*
     * @Column(type="integer", nullale=false)
     */
    protected $member_id;

    /*
     * @Column(type="string", length=6)
     */
    protected $code;

    /*
     * @Column(type="string", length=32)
     */
    protected $pin;

	/*
	 * @Column(type="date")
	 */
	protected $created_at;

	public function getSource() 
	{
		return "cards";
	}

	public function initialize() {
		$this->belongsTo("member_id", "members", "id");

		
	}

	public function getId() { 
		return $this->id;
	}

	public function getMemberId() {
		return $this->member_id;
	}

	public function setMemberId($id) { 
		$this->member_id = $id;
		return $this;
	}

	public function getCode(){ 
		return $this->code;
	}

	public function setCode($code) { 
		$this->code = $code;
		return $this;
	}

	public function getPin(){
		return $this->pin;
	}

	public function setPin($pin){
		$this->pin = $pin;
		return $this;
	}

	public function getCreatedAt(){
		return $this->created_at;
	}

	public function setCreatedAt(\DateTime $date) { 
		$this->created_at = $date;
		return $this;
	}
}
