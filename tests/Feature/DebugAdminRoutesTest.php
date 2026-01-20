<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class DebugAdminRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_debug_admin_users_index_response()
    {
        $admin = User::create(['name' => 'Admin', 'email' => 'admin3@example.com', 'password' => bcrypt('password'), 'role' => 'admin']);

        // First, bypass middleware to ensure the route/controller is functioning
        // Use path-only URL to avoid APP_URL subdirectory interfering with route matching
        $noMiddlewareResp = $this->withoutMiddleware()->actingAs($admin)->get('/admin/users');
        // Write route info for debugging
        $route = \Illuminate\Support\Facades\Route::getRoutes()->getByName('admin.users.index');
        file_put_contents(storage_path('logs/debug_admin_route.txt'), $route ? $route->uri() : 'route-not-found');

        // Try to match the request manually via the router to see what it resolves to
        $req = \Illuminate\Http\Request::create(route('admin.users.index'), 'GET');
        try {
            $matched = app('router')->getRoutes()->match($req);
            file_put_contents(storage_path('logs/debug_admin_matched.txt'), $matched->uri());
            // Dump gathered middleware for the matched route
            file_put_contents(storage_path('logs/debug_admin_middleware.json'), json_encode($matched->gatherMiddleware()));
            file_put_contents(storage_path('logs/debug_admin_action.json'), json_encode($matched->getAction()));
            // Get resolved middleware list the router will pass to the Pipeline
            $resolved = app('router')->resolveMiddleware($matched->gatherMiddleware(), $matched->excludedMiddleware());
            file_put_contents(storage_path('logs/debug_admin_resolved_middleware.json'), json_encode($resolved));
        } catch (\Exception $e) {
            file_put_contents(storage_path('logs/debug_admin_matched.txt'), 'no-match: ' . $e->getMessage());
        }

        // Also try to call the controller action directly
        $controller = new \App\Http\Controllers\AdminUserController();
        $directResp = $controller->index();
        // Render view content to inspect
        if (is_object($directResp) && method_exists($directResp, 'render')) {
            $content = $directResp->render();
            file_put_contents(storage_path('logs/debug_admin_direct.html'), $content);
        } else {
            file_put_contents(storage_path('logs/debug_admin_direct.txt'), 'no view returned');
        }
        if ($noMiddlewareResp->status() !== 200) {
            file_put_contents(storage_path('logs/debug_admin_no_middleware.html'), $noMiddlewareResp->getContent());
        }
        $noMiddlewareResp->assertStatus(200);

        // Then test with middleware enabled to reproduce failing behavior
        $this->withoutExceptionHandling();

        // Try excluding just AdminMiddleware
        $respExcludeAdmin = $this->withoutMiddleware([\App\Http\Middleware\AdminMiddleware::class])->actingAs($admin)->get('/admin/users');
        file_put_contents(storage_path('logs/debug_admin_exclude_admin.txt'), (string) $respExcludeAdmin->status());

        // Try excluding just Authenticate middleware
        $respExcludeAuth = $this->withoutMiddleware([\App\Http\Middleware\Authenticate::class])->actingAs($admin)->get('/admin/users');
        file_put_contents(storage_path('logs/debug_admin_exclude_auth.txt'), (string) $respExcludeAuth->status());

        // Try excluding web group
        $respExcludeWeb = $this->withoutMiddleware(['web'])->actingAs($admin)->get('/admin/users');
        file_put_contents(storage_path('logs/debug_admin_exclude_web.txt'), (string) $respExcludeWeb->status());

        // Full middleware
        $response = $this->actingAs($admin)->get('/admin/users');
        if ($response->status() !== 200) {
            file_put_contents(storage_path('logs/debug_admin_response.html'), $response->getContent());
            $this->fail('Response not OK; content written to storage/logs/debug_admin_response.html');
        }

        $response->assertStatus(200);
    }
}
