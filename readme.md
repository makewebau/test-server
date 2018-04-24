# MakeWeb Test Server

Test code which sends HTTP requests by spinning up an actual HTTP server on your local environment.

The server serves a basic Lumen app served with PHP's built in development web server. You can then
define the behaviour of the test server by adding routes with closures right in your test code. This way
we can keep the test code which relies on specific server behaviour tightly coupled with the code
which defines the behaviour.

The idea and original code was forked from the implementation of a web server for testing KiteTail's
Zttp library by Adam Wathan. Do check out [Zttp](https://github.com/kitetail/zttp), and [KiteTail](https://kitetail.co/).

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
    public function a_get_request_to_add_route_returns_sum_of_a_and_b_parameters_as_result()
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

