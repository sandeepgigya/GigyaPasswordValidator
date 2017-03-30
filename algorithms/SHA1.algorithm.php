<?php

class SHA1 extends Algorithm {

	public function __construct()
	{
		parent::__construct();
		$this->displayName = "SHA1";
		$this->gigyaAlgorithm = "sha1";
		$this->requiresSalt = false;
		$this->requiresURL = false;
	}

	public function validate($passToHash, $plainPassword, $hashedPassword, $salt, $hashFormat, $rounds = 1, $passEncType, $saltEncType, $url)
	{
		$hashedPassword = ($passEncType === "hex") ? $this->hexToBase64($hashedPassword) : $hashedPassword;
		$tmpl = array();
		$tmpl["password"] = $hashedPassword;
		$tmpl["hashSettings"]["algorithm"] = $this->gigyaAlgorithm;
		$tmpl["hashSettings"]["rounds"] = (int)$rounds;
		if(!empty($salt)) { $tmpl["hashSettings"]["salt"] = $salt; $tmpl["hashSettings"]["format"] = $hashFormat; }
		$this->setTemplateConfig($tmpl);
		return strcasecmp(base64_encode(sha1($passToHash, true)), $hashedPassword) == 0;
	}

}