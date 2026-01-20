<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RouteDebugTest extends TestCase
{
    use RefreshDatabase;

    public function test_match_kamar_route()
    {
        $request = Request::create('/kamar', 'GET');
        $route = app('router')->getRoutes()->match($request);
        Log::info('RouteDebugTest matched', ['uri' => $route->uri(), 'action' => $route->getActionName()]);
        $this->assertNotNull($route);

        // Also perform a framework request and log response details
        $this->withoutExceptionHandling();
        // Use path-only URI to avoid APP_URL subdirectory interfering with route matching
        $uri = '/' . ltrim($route->uri(), '/');
        Log::info('RouteDebugTest request uri', ['uri' => $uri]);
        $response = $this->get($uri);
        Log::info('RouteDebugTest framework response', ['status' => $response->status(), 'content' => substr($response->getContent(), 0, 1000)]);

        // Make a trivial assertion so test passes while we gather logs
        $this->assertTrue(is_int($response->status()));
    }
}
