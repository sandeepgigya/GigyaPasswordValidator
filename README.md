# Gigya Password Validation Tool

A PHP Script that will allow you to validate a password hash to ensure compatibility with Gigya. You are able to add custom algorithms using a simple class.

## New Algorithm Setup

It can take a very short time to set up a new algorithm on the tool - simply copy the template from `template/TEMPLATE.algorithm.php` and paste it in to `/algorithms`.

As an example - to implement logic for a SHA512 hash rename the filename and class names to the name of your algorithm.

### SHA512.algorithm.php

Modifying the class to be called `class SHA512 extends Algorithm`

There are a few configuration items that define the rules for this algorithm.

``` PHP
$this->displayName = "Template";
$this->gigyaAlgorithm = "template";
$this->requiresSalt = false;
$this->requiresURL = false;
````

* Display Name - Is the name of the algorithm for the front end of the application
* gigyaAlgorithm - Is the actual function name that should be included in the JSON Import file (This must be already set up within Gigya).
* requiresSalt - If a salt is a required parameter
* requiresURL - If the specific hashing algorithm requires a URL parameter

The validate function of this class provides hashing information from the front end that can be used to create logic to validate the hash.

* $passToHash - The plain text password based off the hash format (i.e. Gigya1234)
* $plainPassword - The plain text password (i.e. Gigya)
* $hashedPassword - The hashed version of the password to validate against (E97B3CB33062122832AAED32A34016A0D52D0A4272875757084976C643A3FDD09DF3BF628E7106504FCFED7BA131869BFC8CE1C6E0F2BEB3CEDD6894331AB220)
* $salt - The salt that is used in the password (i.e. 1234)
* $hashFormat - The password hash format to determine location of the salt ($password$salt)
* $rounds - The amount of hashing rounds (i.e. 1)
* $passEncType - If the password provided in the UI is either a hex or base64 value
* $saltEncType - If the salt provided in the UI is either a hex or base64 value
* $url - The URL endpoint passed in the UI

The template in the validate function allows you to define what specific password settings are needed for the import file. An example of a fully generated template looks like

```` JSON
{
  "password": "0oob6zSvBZ6wcBQI7/YxDo+nJ2U6VCpEP17+dJRBA4E=",
  "hashSettings": {
    "algorithm": "sha256",
    "rounds": 1,
    "salt": "123",
    "format": "$password$salt"
  }
}
````

The final part is to include your implementation of the hashing algorithm and return either true or false to confirm `$hashedPassword` matches the hashed version of `$passToHash`

## Demo

A demo can be found at https://tools.gigya-cs.com/password