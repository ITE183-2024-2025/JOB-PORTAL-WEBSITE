<?php

namespace Tests\Unit\Core;

use App\Core\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    protected $router;

    protected function setUp(): void
    {
        $this->router = new Router();
    }

    public function testGetRouteRegistration()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $this->router->get('/test', function() { return 'GET Test'; });
        $result = $this->router->dispatch('/test');
        $this->assertEquals('GET Test', $result);
    }

    public function testPostRouteRegistration()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $this->router->post('/test', function() { return 'POST Test'; });
        $result = $this->router->dispatch('/test');
        $this->assertEquals('POST Test', $result);
    }

    public function testRouteNotFound()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $result = $this->router->dispatch('/nonexistent');
        $this->assertEquals('404 Not Found', $result);
    }
}
