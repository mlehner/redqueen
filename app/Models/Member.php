<?php

class Member extends \Phalcon\Mvc\Model 
{
	const GENDER_MALE = 1, 
		  GENDER_FEMALE = 2;
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

	/*
	 * @Column(type="integer")
	 */
	public $gender;

	public function getSource()
	{
		return "members";
	}

	public function initialize() { 
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
}
