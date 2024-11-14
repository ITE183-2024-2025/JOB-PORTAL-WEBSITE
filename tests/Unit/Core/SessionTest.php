<?php

namespace Tests\Unit\Core;

use App\Core\Session;
use PHPUnit\Framework\TestCase;

class SessionTest extends TestCase
{
    protected function setUp(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
        Session::start();
    }

    public function testSetAndGetSessionValue()
    {
        Session::set('test_key', 'test_value');
        $this->assertEquals('test_value', Session::get('test_key'));
    }

    public function testUnsetSessionValue()
    {
        Session::set('test_key', 'test_value');
        Session::set('test_key', null);
        $this->assertNull(Session::get('test_key'));
    }

    // public function testDestroySession()
    // {
    //     Session::set('test_key', 'test_value');
    //     Session::destroy();
    
    //     $this->assertEmpty($_SESSION);
    // }
    
}
