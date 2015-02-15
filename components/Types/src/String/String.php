<?php

namespace Vibius\Types\String;

use Vibius\Types\Type\Type as Type;
use Vibius\Types\String\Rules\Rules as StringRules;

/**
 * @package Vibius\Types\String
 * @author Matej Sima (maht0rz) <matej.sima@gmail.com>
 * 
 * Defines type of String for Vibius\Types\Validator
 */
class String extends Type{

	/**
	 * 
	 */
	public function __construct(){
		$this->setRules(new StringRules($this));
	}

	
}