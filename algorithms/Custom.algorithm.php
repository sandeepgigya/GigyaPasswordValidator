<?php

class Custom extends Algorithm {

	public function __construct()
	{
		parent::__construct();
		$this->displayName = "Custom";
		$this->gigyaAlgorithm = "custom";
		$this->requiresSalt = false;
		$this->requiresURL = true;
	}

	public function validate($passToHash, $plainPassword, $hashedPassword, $salt, $hashFormat, $rounds = 1, $passEncType, $saltEncType, $url) {
		$tmpl = array();
		$tmpl["password"] = $hashedPassword;
		$tmpl["hashSettings"]["algorithm"] = $this->gigyaAlgorithm;
		if(!empty($salt)) $tmpl["hashSettings"]["salt"] = $salt;
		$tmpl["hashSettings"]["url"] = $url;
		$this->setTemplateConfig($tmpl);

		$response = json_decode(file_get_contents("$url?password=$plainPassword&pwHashSalt=$salt"), true);
		return strcasecmp($response["hashedPassword"], $hashedPassword) == 0;

	}

}