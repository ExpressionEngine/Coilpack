<?php

namespace Tests;

use Expressionengine\Coilpack\Response;

class ResponseTest extends TestCase
{
    public function test_parsing_headers_with_multiple_colons()
    {
        ee()->output->set_header('test: one:two:three');

        $response = (new Response)->fromOutput();

        $this->assertEquals($response->headers->get('Expires'), 'Mon, 26 Jul 1997 05:00:00 GMT');
        $this->assertEquals($response->headers->get('test'), 'one:two:three');
    }
}
