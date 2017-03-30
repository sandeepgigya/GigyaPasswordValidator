<?php

class Algorithm {

	/* General Config */
	protected $displayName;
	protected $gigyaAlgorithm;
	protected $requiresSalt;
	protected $requiresURL;
	protected $templateConfig;
	/* / General Config */


	protected function __construct() {
		
	}

	public function hexToBase64($hex)
	{
		$return = '';
		  foreach(str_split($hex, 2) as $pair){
		    $return .= chr(hexdec($pair));
		  }
		  return base64_encode($return);  
	}

	public function setTemplateConfig($config)
	{
		$this->templateConfig = $config;
	}

	public function getDisplayName()
	{
		return $this->displayName;
	}

	public function getGigyaAlgorithm()
	{
		return $this->gigyaAlgorithm;
	}

	public function getTemplate()
	{
		return json_encode($this->templateConfig);
	}

	public function getConfig()
	{
		$arr = [];
		$arr["requiresSalt"] = $this->requiresSalt;
		$arr["requiresURL"] = $this->requiresURL;
		return $arr;
	}
}