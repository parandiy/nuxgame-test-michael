<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\LinkService;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    private const TEST_USERNAME = 'test name qqdwqgrsf';
    private const TEST_PHONE = '+0123987456-33';
    private User $user;

    private UserService $userService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->linkService = new LinkService();
        $this->userService = new UserService($this->linkService);
        $this->user = $this->userService->createUserWithAccess(self::TEST_USERNAME, self::TEST_PHONE);
    }

    protected function tearDown(): void
    {
        $user = User::where('phone', self::TEST_PHONE)->first();
        $user->accesses()->delete();
        $user->games()->delete();
        $user->delete();

        parent::tearDown();
    }

    /**
     * Testing page displayed.
     */
    public function test_index(): void
    {
        $response = $this->get(route('dashboard.index', ['hash' => $this->user->getValidAccessHash()]));

        $response->assertStatus(200);
    }

    /**
     * Testing playing.
     */
    public function test_play(): void
    {
        $response = $this->post(route('dashboard.play', ['hash' => $this->user->getValidAccessHash()]));

        $response->assertStatus(302)
            ->assertRedirectToRoute('dashboard.index', ['hash' => $this->user->getValidAccessHash()])
            ->assertSessionHas('message');
    }

    /**
     * Testing history displayed.
     */
    public function test_history(): void
    {
        $response = $this->get(route('dashboard.history', ['hash' => $this->user->getValidAccessHash()]));

        $response->assertStatus(200);
    }

    /**
     * Testing regenerate link.
     */
    public function test_regenerate_link(): void
    {
        $response = $this->get(route('dashboard.link.regenerate', ['hash' => $this->user->getValidAccessHash()]));

        $response->assertStatus(302);
    }

    /**
     * Testing deactivate link.
     */
    public function test_deactivate_link(): void
    {
        $response = $this->get(route('dashboard.link.deactivate', ['hash' => $this->user->getValidAccessHash()]));

        $response->assertStatus(302)
            ->assertRedirectToRoute('dashboard.expired');
    }

    /**
     * Testing access deactivated.
     */
    public function test_access_deactivated(): void
    {
        $response = $this->get(route('dashboard.link.deactivate', ['hash' => $this->user->getValidAccessHash()]));

        $response = $this->get(route('dashboard.index', ['hash' => $this->user->getValidAccessHash()]));

        $response->assertStatus(302)
            ->assertRedirectToRoute('dashboard.expired');
    }

    /**
     * Testing access random link.
     */
    public function test_access_random(): void
    {
        $response = $this->get(route('dashboard.index', ['hash' => $this->linkService->generateHash()]));

        $response->assertStatus(404);
    }
}
