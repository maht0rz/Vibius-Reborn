<?php

namespace Vibius\Types\Type;

/**
 * @package Vibius\Types\Type
 * @author Matej Sima (maht0rz) <matej.sima@gmail.com>
 * 
 * Defines general Type
 */
class Type{

	/**
	 * @var TypeRules Holds instance of rules for current Type
	 * Must be set explicitly in constructor of given Type
	 */
	private $rules;

	protected function setRules(TypeRules $rules){
		$this->rules = $rules;
	}

	/**
	 * @return bool If current type content is valid
	 * @throws Vibius\Types\Type\TypeRulesMismatchException
	 */
	public function isValid(){
		return $this->rules->validate();
	}
}