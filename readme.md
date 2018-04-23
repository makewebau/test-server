# MakeWeb Test Server

Test code which sends HTTP requests by spinning up an actual HTTP server on your local environment.

The server serves a basic Lumen app served with PHP's built in development web server. You can then
define the behaviour of the test server by adding routes with closures right in your test code. This way
we can keep the test code which relies on specific server behaviour tightly coupled with the code
which defines the behaviour.

The idea and original code was forked from the implementation of a web server for testing KiteTail's
Zttp library by Adam Wathan et al. Do check out Zttp, and KiteTail.

https://github.com/kitetail/zttp
https://kitetail.co/

## Installation

### Install with Composer

    composer require makeweb/test-server

## Basic usage

```php

<?php

use PHPUnit\Framework\TestCase;
use MakeWeb\TestServer\TestServer;
use Zttp\Zttp;

class MyExampleTest extends TestCase
{
    /** @test */
    public function a_get_request_to_test_returns_expected_response()
    {
        // Set up how we want the test server to respond
        (new TestServer)->withRoute('get', 'add', function ($request) {
            return response()->json(['result' => (int) $request->a + (int) $request->b]);
        })->start();

        $response = Zttp::get('add', ['a' => 1, 'b' => 2]);

        $this->assertEquals(3, $response->result);
    }
}
```

