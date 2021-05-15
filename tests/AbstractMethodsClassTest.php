<?php

namespace Imanghafoori\LaravelMicroscope\Tests;

use Imanghafoori\LaravelMicroscope\Analyzers\ClassMethods;
use Imanghafoori\LaravelMicroscope\LaravelMicroscopeServiceProvider;
use Orchestra\Testbench\TestCase;

class AbstractMethodsClassTest extends TestCase
{
    /** @var array */
    private $classToken;

    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [LaravelMicroscopeServiceProvider::class];
    }

    /** @test */
    public function check_is_abstract_method_test()
    {
        $class = ClassMethods::read($this->getTokens('/stubs/abstract_sample_class.php'));

        // Checks all the methods are abstract
        $this->assertEquals(true, $class['methods'][0]['is_abstract']);
        $this->assertEquals(true, $class['methods'][1]['is_abstract']);
        $this->assertEquals(true, $class['methods'][2]['is_abstract']);
        $this->assertEquals(true, $class['methods'][3]['is_abstract']);
        $this->assertEquals(true, $class['methods'][4]['is_abstract']);
        $this->assertEquals(true, $class['methods'][5]['is_abstract']);
        $this->assertEquals(true, $class['methods'][6]['is_abstract']);
        $this->assertEquals(true, $class['methods'][7]['is_abstract']);
        $this->assertEquals(true, $class['methods'][8]['is_abstract']);
        $this->assertEquals(true, $class['methods'][9]['is_abstract']);
        $this->assertEquals(true, $class['methods'][10]['is_abstract']);
        $this->assertEquals(true, $class['methods'][11]['is_abstract']);
        $this->assertEquals(true, $class['methods'][12]['is_abstract']);
        $this->assertEquals(true, $class['methods'][13]['is_abstract']);
        $this->assertEquals(true, $class['methods'][14]['is_abstract']);
        $this->assertEquals(true, $class['methods'][15]['is_abstract']);
        $this->assertEquals(true, $class['methods'][16]['is_abstract']);
        $this->assertEquals(true, $class['methods'][17]['is_abstract']);
        $this->assertEquals(true, $class['methods'][18]['is_abstract']);
        $this->assertEquals(true, $class['methods'][19]['is_abstract']);
        $this->assertEquals(true, $class['methods'][20]['is_abstract']);
        $this->assertEquals(true, $class['methods'][21]['is_abstract']);
        $this->assertEquals(true, $class['methods'][22]['is_abstract']);
        $this->assertEquals(true, $class['methods'][23]['is_abstract']);
        $this->assertEquals(true, $class['methods'][24]['is_abstract']);
        $this->assertEquals(true, $class['methods'][25]['is_abstract']);
        $this->assertFalse(false, $class['methods'][26]['is_abstract']);
    }

    /** @test */
    public function check_return_types_test()
    {
        $class = ClassMethods::read($this->getTokens('/stubs/abstract_sample_class.php'));
        // check is nullable return types
        $this->assertEquals(null, $class['methods'][0]['nullable_return_type']);
        $this->assertEquals(false, $class['methods'][6]['nullable_return_type']);
        $this->assertEquals(true, $class['methods'][13]['nullable_return_type']);

        $this->assertEquals(null, $class['methods'][0]['returnType']);
        $this->assertEquals('test', $class['methods'][6]['returnType'][1]);
        $this->assertEquals('string', $class['methods'][7]['returnType'][1]);
        $this->assertEquals('bool', $class['methods'][8]['returnType'][1]);
        $this->assertEquals('int', $class['methods'][9]['returnType'][1]);
        $this->assertEquals('array', $class['methods'][10]['returnType'][1]);
        $this->assertEquals('void', $class['methods'][11]['returnType'][1]);
        $this->assertEquals('float', $class['methods'][12]['returnType'][1]);
        $this->assertEquals('string', $class['methods'][13]['returnType'][1]);
    }

    /** @test */
    public function check_visibility_test()
    {
        $class = ClassMethods::read($this->getTokens('/stubs/abstract_sample_class.php'));

        $this->assertEquals('public', $class['methods'][0]['visibility'][1]);
        $this->assertEquals('public', $class['methods'][1]['visibility'][1]);
        $this->assertEquals('protected', $class['methods'][2]['visibility'][1]);
        $this->assertEquals('public', $class['methods'][3]['visibility'][1]);
        $this->assertEquals('public', $class['methods'][4]['visibility'][1]);
        $this->assertEquals('protected', $class['methods'][5]['visibility'][1]);
        $this->assertEquals('public', $class['methods'][6]['visibility'][1]);
        $this->assertEquals('public', $class['methods'][7]['visibility'][1]);
        $this->assertEquals('public', $class['methods'][8]['visibility'][1]);
        $this->assertEquals('public', $class['methods'][9]['visibility'][1]);

        $this->assertEquals('public', $class['methods'][22]['visibility'][1]);
        $this->assertEquals('public', $class['methods'][23]['visibility'][1]);
        $this->assertEquals('protected', $class['methods'][24]['visibility'][1]);
        $this->assertEquals('public', $class['methods'][25]['visibility'][1]);
    }

    /** @test */
    public function check_is_static_method_test()
    {
        $class = ClassMethods::read($this->getTokens('/stubs/abstract_sample_class.php'));

        $this->assertEquals(true, $class['methods'][3]['is_static']);
        $this->assertEquals(true, $class['methods'][4]['is_static']);
        $this->assertEquals(true, $class['methods'][5]['is_static']);
        $this->assertEquals(true, $class['methods'][25]['is_static']);
    }

    /** @test  */
    public function abstract_class_general_body_test()
    {
        $class = ClassMethods::read($this->getTokens('/stubs/abstract_sample_class.php'));

        $this->assertEquals([311, 'abstract_sample', 9], $class['name']);
        $this->assertCount(27, $class['methods']);
        $this->assertTrue($class['is_abstract']);
        $this->assertEquals(T_CLASS, $class['type']);
    }

    /** @test */
    public function check_parameter_methods()
    {
        $class = ClassMethods::read($this->getTokens('/stubs/abstract_sample_class.php'));
        // check function has parameter
        $this->assertEquals('$parameter1', $class['methods'][14]['signature'][0][1]);
        // check nullable type cast method parameters
        $this->assertEquals('?', $class['methods'][15]['signature'][0]);
        $this->assertEquals('int', $class['methods'][15]['signature'][1][1]);
        $this->assertEquals('$parameter1', $class['methods'][15]['signature'][3][1]);
        // check type hinting of parameters
        $this->assertEquals('int', $class['methods'][16]['signature'][0][1]);
        // number of parameter
        $signatures = $class['methods'][17]['signature'];
        $parameters = array_filter($signatures, function ($item) {
            return is_array($item) && substr($item[1], 0, 1) == '$';
        });

        $this->assertCount(3, $parameters);
        // check multi parameter with type
        $this->assertEquals('...', $class['methods'][18]['signature'][0][1]);
        $this->assertEquals('$parameter2', $class['methods'][18]['signature'][1][1]);

        // check multi parameter with type casting
        $this->assertEquals('string', $class['methods'][19]['signature'][0][1]);
        $this->assertEquals('...', $class['methods'][19]['signature'][2][1]);
        $this->assertEquals('$parameter1', $class['methods'][19]['signature'][3][1]);

        // check method with nullable multi parameter
        $this->assertEquals('?', $class['methods'][20]['signature'][0]);
        $this->assertEquals('string', $class['methods'][20]['signature'][1][1]);
        $this->assertEquals('...', $class['methods'][20]['signature'][3][1]);
        $this->assertEquals('$parameter1', $class['methods'][20]['signature'][4][1]);

        // check default value of parameters
        $this->assertEquals('$parameter1', $class['methods'][21]['signature'][0][1]);
        $this->assertEquals('=', $class['methods'][21]['signature'][2]);
        $this->assertEquals('null', $class['methods'][21]['signature'][4][1]);
    }

    private function getTokens($path)
    {
        return token_get_all(file_get_contents(__DIR__.$path));
    }
}
