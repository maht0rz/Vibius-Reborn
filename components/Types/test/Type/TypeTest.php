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

	public function preparedInstanceProvider(){
		/*
			I was unable to pass result of testSetRulesMethodShouldSetRulesProperty
			to current test method via @depends, so here's a quick&dirty workaround
		*/
		return call_user_func_array(
			[$this,'testSetRulesMethodShouldSetRulesProperty'],
			 $this->groupedProvider()[0]
		);
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
		ReflectionProperty $rulesProperty, ReflectionMethod $setRulesMethod, $stub = false
	){	
		$typeRulesInstance = new Vibius\Types\Type\TypeRules();
		if($stub) $typeRulesInstance = $stub;
		$setRulesMethod->setAccessible(true);
		$setRulesMethod->invoke($this->instance, $typeRulesInstance);

		$rulesProperty->setAccessible(true);
		
		$this->assertEquals($typeRulesInstance, $rulesProperty->getValue($this->instance));	

		return $this->instance;
	}

	/**
	 * @depends testSetRulesMethodShouldSetRulesProperty
	 */
	public function testShouldValidateGivenRulesForType(){
		$preparedInstance = $this->preparedInstanceProvider();

		$this->assertTrue($preparedInstance->isValid());
	}

	/**
	 * @depends testSetRulesMethodShouldSetRulesProperty
	 * @dataProvider groupedProvider
	 */
	public function testShouldValidateGivenRulesForTypeWithUnmatchedRule(
		ReflectionProperty $rulesProperty, ReflectionMethod $setRulesMethod
	){
		$stub = $this->getMockBuilder('Vibius\Types\Type\TypeRules')
					 ->getMock();
		$stub->method('validate')
			 ->willReturn(false);

		$preparedInstance = $this->testSetRulesMethodShouldSetRulesProperty(
			$rulesProperty, $setRulesMethod, $stub
		);

		$this->assertFalse($preparedInstance->isValid());
	}
}