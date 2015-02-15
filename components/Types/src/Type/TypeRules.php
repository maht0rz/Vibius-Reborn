<?php

namespace Vibius\Types\Type;

/**
 * @package Vibius\Types\Type
 * @author Matej Sima (maht0rz) <matej.sima@gmail.com>
 * 
 * Defines general TypeRules for Type
 */
class TypeRules{

	/**
	 * @return array Of class methods which are rules
	 */
	protected function getAllRules(){
		return array_filter(get_class_methods($this), function($methodName){
			if( preg_match('/(rule)/', $methodName) ) return $methodName;
		});
	}

	protected function validateByRules(array $rules){
		foreach ($rules as $rule) {
			if( !$rule() ) return false;
		}
		return true;
	}

	public function validate(){
		return $this->validateByRules(
			$this->getAllRules()
		);
	}
}