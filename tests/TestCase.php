<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        // Ensure tests are not affected by APP_URL subdirectory (like http://localhost/adakamar)
        $appUrl = config('app.url');
        if ($appUrl) {
            $root = preg_replace('#(https?://[^/]+).*#', '$1', $appUrl);
            \Illuminate\Support\Facades\URL::forceRootUrl($root);
        }
    }
}
