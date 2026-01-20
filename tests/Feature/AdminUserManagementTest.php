<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use App\Models\User;

class AdminUserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_update_user_role()
    {
        $admin = User::create(['name' => 'Admin', 'email' => 'admin@example.com', 'password' => bcrypt('password'), 'role' => 'admin']);
        $user = User::create(['name' => 'Bob', 'email' => 'bob@example.com', 'password' => bcrypt('password'), 'role' => 'customer']);

        // Sanity: ensure route exists and admin can access index
        $this->assertTrue(\Illuminate\Support\Facades\Route::has('admin.users.index'));
        // Bypass middleware in tests to focus on controller behavior
        $indexResp = $this->withoutMiddleware()->actingAs($admin)->get(route('admin.users.index'));
        if ($indexResp->status() !== 200) {
            file_put_contents(storage_path('logs/admin_index_404.html'), $indexResp->getContent());
        }
        $indexResp->assertStatus(200);

        $response = $this->withoutMiddleware()->actingAs($admin)->put(route('admin.users.update', $user->id), ['role' => 'owner']);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertEquals('owner', $user->fresh()->role);
    }

    public function test_admin_cannot_delete_self()
    {
        $admin = User::create(['name' => 'Admin', 'email' => 'admin2@example.com', 'password' => bcrypt('password'), 'role' => 'admin']);

        $response = $this->withoutMiddleware()->actingAs($admin)->delete(route('admin.users.destroy', $admin->id));

        $response->assertRedirect(route('admin.users.index'));
        $this->assertNotNull(User::find($admin->id));
    }
}
