<?php

use Vibius\Types\Type\Type as Type;

class TypeTest extends PHPUnit_Framework_TestCase{

	protected $instance;

	protected function setUp(){
		$this->instance = new Type();
	}

	public function rulesPropertyReflectionProvider(){
		return [
			[(new ReflectionClass('Vibius\Types\Type\Type'))->getProperty('rules')]
		];
	}

	public function setRulesMethodReflectionProvider(){
		return [
			[(new ReflectionClass('Vibius\Types\Type\Type'))->getMethod('setRules')]
		];
	}

	public function groupedProvider(){
		return [
			array_merge(
				$this->rulesPropertyReflectionProvider()[0], 
				$this->setRulesMethodReflectionProvider()[0]
			)
		];
	}

	/**
     * @dataProvider rulesPropertyReflectionProvider
     */
	public function testRulesPropertyShouldBePrivate(ReflectionProperty $rulesProperty){
		$this->assertTrue($rulesProperty->isPrivate());
	}

	/**
     * @dataProvider rulesPropertyReflectionProvider
     */
	public function testRulesPropertyShouldBeNull(ReflectionProperty $rulesProperty){
		$rulesProperty->setAccessible(true);
		$this->assertNull($rulesProperty->getValue($this->instance));
	}

	/**
	 * @depends testRulesPropertyShouldBeNull
	 * @dataProvider groupedProvider
	 */
	public function testSetRulesMethodShouldSetRulesProperty(
		ReflectionProperty $rulesProperty, ReflectionMethod $setRulesMethod)
	{	
		$typeRulesInstance = new Vibius\Types\Type\TypeRules();
		$setRulesMethod->setAccessible(true);
		$setRulesMethod->invoke($this->instance, $typeRulesInstance);

		$rulesProperty->setAccessible(true);
		
		$this->assertEquals($typeRulesInstance, $rulesProperty->getValue($this->instance));	

		return $this->instance;
	}
	
	public function testShouldValidateGivenRulesForType(){
		/*
			I was unable to pass result of testSetRulesMethodShouldSetRulesProperty
			to current test method via @depends, so here's a quick&dirty workaround
		*/
		$preparedInstance = call_user_func_array(
			[$this,'testSetRulesMethodShouldSetRulesProperty'],
			 $this->groupedProvider()[0]
		);

		$this->assertTrue($preparedInstance->isValid());
	}
}