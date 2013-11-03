<?php

class Member extends \Phalcon\Mvc\Model 
{
	const GENDER_MALE = 1, 
		  GENDER_FEMALE = 2;
    /**
     * @Primary
     * @Identity
     * @Column(type="integer", nullable=false)
     */
    protected $id;

    /**
     * @Column(type="string", length=255)
     */
    protected $name;

    /*
     * @Column(type="string", length=255)
     */
    protected $username;

    /*
     * @Column(type="stirng", length=255)
     */
    protected $email;

    /*
     * @Column(type="string", length=255)
     */
    protected $password;

	/*
	 * @Column(type="integer")
	 */
	protected $gender;

	/*
	* One to Many cards
	*/
	protected $cards;

	/*
	 * @Column(type="date")
	 */
	protected $created_at;

	/*
	 * @Column(type="date")
	 */
	protected $updated_at;

	public function getSource()
	{
		return "members";
	}

	public function initialize() { 
		$this->setCreatedAt(new \DateTime('now'))
			->setUpdatedAt(new \DateTime('now'));

		$this->hasMany("id", "cards", "member_id");
	}

	public function getId(){
		return $this->id;
	}

	public function getName(){
		return $this->name;
	}

	public function setName($name){ 
		$this->name = $name;
		return $this;
	}

	public function getUsername(){ 
		return $this->username;
	}

	public function setUsername($username) { 
		$this->username = $username;
		return $this;
	}

	public function getEmail() { 
		return $this->email;
	}

	public function setEmail($email){ 
		$this->email = $email;
		return $this;
	}

	public function setPassword($password) { 
		$this->password = $password;
		return $this;
	}

	public function getGender() {

	}

	public function setGender($gender) { 
		$this->gender = $gender; 
		return $this;
	}

	public function getCreatedAt(){ 
		return $this->created_at;
	}

	public function setCreatedAt(\DateTime $date){
		$this->created_at = $date;	
		return $this;
	}

	public function getUpdatedAt(){ 
		return $this->updated_at;
	}

	public function setUpdatedAt(\DateTime $date){
		$this->updated_at = $date;	
		return $this;
	}

	public function getCards()
	{ 
		return $this->cards;
	}
}
