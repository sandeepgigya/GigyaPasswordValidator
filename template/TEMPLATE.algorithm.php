<?php

class Template extends Algorithm {

	public function __construct()
	{
		parent::__construct();
		$this->displayName = "Template";
		$this->gigyaAlgorithm = "template";
		$this->requiresSalt = false;
		$this->requiresURL = false;
	}

	public function validate($passToHash, $plainPassword, $hashedPassword, $salt, $hashFormat, $rounds = 1, $passEncType, $saltEncType, $url) {

		// Remove/Add paramters as needed for this specific template
		$tmpl = array();
		$tmpl["password"] = $hashedPassword;
		$tmpl["hashSettings"]["algorithm"] = $this->gigyaAlgorithm;
		if(!empty($salt)) $tmpl["hashSettings"]["salt"] = $salt;
		$tmpl["hashSettings"]["url"] = $url;
		$tmpl["hashSettings"]["rounds"] = (int)$rounds;
		if(!empty($salt)) { $tmpl["hashSettings"]["salt"] = $salt; $tmpl["hashSettings"]["format"] = $hashFormat; }
		$this->setTemplateConfig($tmpl);

		// Insert hashing algorithm logic here
		return false;

	}

}