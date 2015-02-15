<?php 

namespace Vibius\Types\String\Rules;

use Vibius\Types\Type\Type as Type;
use Vibius\Types\Type\TypeRules as TypeRules;

/**
 * @package Vibius\Types\String\Rules
 * @author Matej Sima (maht0rz) <matej.sima@gmail.com>
 * 
 * Defines validation rules for type of String
 */
class Rules extends TypeRules{

	/**
	 * @var Type $content Holds content to validate
	 */
	protected $content;

	/**
	 * @param Type $content Content of given Type to be validated against available rules
	 */
	public function __construct(Type &$content){
		$this->content = $content;
	}

	/**
	 * @return bool True if rule was satisfied
	 * Validates given type as built-in string type
	 */
	public function ruleMustBeString(){
		if( is_string($this->content) ) return true;
	}

}