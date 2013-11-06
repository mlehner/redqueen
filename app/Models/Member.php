<?php

use Phalcon\Mvc\Model\Behavior\Timestampable;

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
	 * @Column(type="string")
	 */
	protected $created_at;

	/*
	 * @Column(type="string")
	 */
	protected $updated_at;

	public function getSource()
	{
		return "members";
	}

	/*
	 * @TODO I should be replaced 
	 */
	private function dateFormat($date){
		if ($date instanceof \DateTime){ 
			return $date->format('Y-m-d H:i:s P');
		} else { 
			return new \Datetime($date);
		}
	}

	public function initialize() { 
		$this->setUpdatedAt(new \DateTime('now'));

		/*
		 * It would be nice to use these
		 *
		$this->addBehavior(new Timestampable(
			array(
				'beforeCreate' => array(
					'field' => 'created_at',
					'format' => $dateFormat()
				),
				'beforeCreate' => array(
					'field' => 'updated_at',
					'format' => $dateFormat()
				), 
			)
		));
		*/

		$this->hasMany("id", "Cards", "member_id");
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

	public function getPassword(){ 
		return $this->password;
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
		return $this->dateFormat($this->created_at);
	}

	public function setCreatedAt($date){
		$this->created_at = $this->dateFormat($date);	

		return $this;
	}

	public function getUpdatedAt(){ 
		return $this->dateFormat($this->updated_at);
	}

	public function setUpdatedAt($date){
		$this->updated_at = $this->dateFormat($date);	
		return $this;
	}
}
