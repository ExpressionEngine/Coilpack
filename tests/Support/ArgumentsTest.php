<?php

namespace Tests\Tag;

use Expressionengine\Coilpack\Support\Arguments;
use PHPUnit\Framework\TestCase;

class ArgumentsTest extends TestCase
{
    public function test_argument()
    {
        $argument = new Arguments\SearchArgument('pickles|shoes');

        $this->assertFalse($argument->not);
        $this->assertEquals('or', $argument->boolean);
        $this->assertCount(2, $argument->terms);
    }

    public function test_exact_argument()
    {
        $argument = new Arguments\SearchArgument('=pickles|shoes');

        $this->assertTrue($argument->exact);
        $this->assertCount(2, $argument->terms);
    }

    public function test_exact_not_argument()
    {
        $argument = new Arguments\SearchArgument('=not pickles|shoes');

        $this->assertTrue($argument->exact);
        $this->assertTrue($argument->not);
        $this->assertCount(2, $argument->terms);
    }

    public function test_not_argument()
    {
        $argument = new Arguments\SearchArgument('not pickles|shoes');

        $this->assertTrue($argument->not);
        $this->assertCount(2, $argument->terms);
    }

    public function test_boolean_and_argument()
    {
        $argument = new Arguments\SearchArgument('pickles&&shoes');

        $this->assertEquals('and', $argument->boolean);
        $this->assertCount(2, $argument->terms);
    }

    public function test_boolean_and_not_argument()
    {
        $argument = new Arguments\SearchArgument('not pickles&&shoes');

        $this->assertEquals('or', $argument->boolean);
        $this->assertTrue($argument->not);
        $this->assertCount(2, $argument->terms);
    }

    public function test_whole_word_argument()
    {
        $argument = new Arguments\SearchArgument('cat\W');

        $this->assertCount(1, $argument->terms);
        $this->assertTrue($argument->terms[0]->wholeWord);
    }

    public function is_empty_argument()
    {
        $argument = new Arguments\SearchArgument('IS_EMPTY');

        $this->assertCount(1, $argument->terms);
        $this->assertEquals(Arguments\EmptyTerm::class, get_class($argument->terms->first()));
    }

    public function not_is_empty_argument()
    {
        $argument = new Arguments\SearchArgument('not IS_EMPTY');

        $this->assertCount(1, $argument->terms);
        $this->assertEquals(Arguments\EmptyTerm::class, get_class($argument->terms->first()));
    }

    public function exact_is_empty_argument()
    {
        $argument = new Arguments\SearchArgument('=IS_EMPTY|sandwich');

        $this->assertCount(2, $argument->terms);
        $this->assertEquals(Arguments\EmptyTerm::class, get_class($argument->terms->first()));
    }

    public function contains_is_empty_argument()
    {
        $argument = new Arguments\SearchArgument('IS_EMPTY|sandwich');

        $this->assertCount(2, $argument->terms);
        $this->assertEquals(Arguments\EmptyTerm::class, get_class($argument->terms->first()));
    }

    public function contains_not_is_empty_argument()
    {
        $argument = new Arguments\SearchArgument('not IS_EMPTY|sandwich|salad');

        $this->assertTrue($argument->not);
        $this->assertCount(2, $argument->terms);
        $this->assertEquals(Arguments\EmptyTerm::class, get_class($argument->terms->first()));
    }
}
