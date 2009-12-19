<?php

/**
 * @author lesperancej
 *
 */
class Members_Model_Members
{
	protected $_id;
	protected $_firstName;
	protected $_lastName;
	protected $_email;
	protected $_username;
	protected $_password;
	protected $_active;
	protected $_joined;
	protected $_mapper;

	public function __construct(array $options = null)
	{
		if (is_array($options)) {
			$this->setOptions($options);
		}
	}

	/**
	 * Overloading: allow property access
	 *
	 * @param  string $name
	 * @param  mixed $value
	 * @return void
	 */
	public function __set($name, $value)
	{
		$method = 'set' . $name;
		if ('mapper' == $name || !method_exists($this, $method)) {
			throw Exception('Invalid property specified');
		}
		$this->$method($value);
	}

	/**
	 * Overloading: allow property access
	 *
	 * @param  string $name
	 * @return mixed
	 */
	public function __get($name)
	{
		$method = 'get' . $name;
		if ('mapper' == $name || !method_exists($this, $method)) {
			throw new Exception('Invalid property specified');
		}
		return $this->$method();
	}

	public function setOptions(array $options)
	{
		$methods = get_class_methods($this);
		foreach ($options as $key => $value) {
			$method = 'set' . ucfirst($key);
			if (in_array($method, $methods)) {
				$this->$method($value);
			}
		}
		return $this;
	}

	public function setId($id)
	{
		$this->_id = $id;
		return $this;
	}

	public function getId()
	{
		return $this->_id;
	}

	public function setFirstName($firstName)
	{
		$this->_firstName = $firstName;
		return $this;
	}

	public function getFirstName()
	{
		return $this->_firstName;
	}

	public function setLastName($lastName)
	{
		$this->_lastName = $lastName;
		return $this;
	}

	public function getLastName()
	{
		return $this->_lastName;
	}

	public function setEmail($email)
	{
		$this->_email = $email;
		return $this;
	}

	public function getEmail()
	{
		return $this->_email;
	}

	public function setUsername($username)
	{
		$this->_username = $username;
		return $this;
	}

	public function getUsername()
	{
		return $this->_username;
	}

	public function setPassword($password)
	{
		$this->_password = $password;
		return $this;
	}

	public function getPassword()
	{
		return $this->_password;
	}

	public function setActive($active)
	{
		$this->_active = $active;
		return $this;
	}

	public function getActive()
	{
		return $this->_active;
	}

	public function setJoined($joined)
	{
		$this->_joined = $joined;
		return $this;
	}

	public function getJoined()
	{
		return $this->_joined;
	}

	public function setMapper($mapper)
	{
		$this->_mapper = $mapper;
		return $this;
	}

	/**
	 * Get data mapper
	 *
	 * Lazy loads Default_Model_GuestbookMapper instance if no mapper registered
	 *
	 * @return Default_Model_GuestbookMapper
	 */
	public function getMapper()
	{
		if (null === $this->_mapper) {
			$this->setMapper(new Members_Model_MembersMapper());
		}
		return $this->_mapper;
	}
	
	public function save()
	{
		$this->getMapper()->save($this);
	}
	
	public function updateEmail($email)
	{
		$this->getMapper()->updateEmail($email);
	}
	
	public function updatePassword($password)
	{
		$this->getMapper()->updatePassword($password);
	}

	public function fetchMember(){
		$this->getMapper()->fetchMembers($this);
	}
}
