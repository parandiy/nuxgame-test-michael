<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistrationControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * Testing page displayed.
     */
    public function test_index(): void
    {
        $response = $this->get(route('registration.index'));

        $response->assertStatus(200)
            ->assertViewIs('registration.index');
    }

    /**
     * Testing registration success.
     */
    public function test_store(): void
    {
        $data = [
            'name' => $this->faker->userName,
            'phone' => $this->faker->phoneNumber,
        ];

        $response = $this->post(route('registration.store'), $data);

        $this->assertDatabaseHas('users', [
            'name' => $data['name'],
            'phone' => $data['phone'],
        ]);

        $response->assertStatus(302)
            ->assertRedirectToRoute('registration.index')
            ->assertSessionHas('link');
    }

    /**
     * Testing registration validation empty data.
     */
    public function test_store_empty_data(): void
    {
        $response = $this->post(route('registration.store'), ['name' => '', 'phone' => '']);

        $response->assertStatus(302)
            ->assertRedirectToRoute('registration.index')
            ->assertSessionHasErrors(['name', 'phone']);
    }

    /**
     * Testing registration validation unique phone.
     */
    public function test_store_not_unique_phone_number(): void
    {
        $data = [
            'name' => $this->faker->userName,
            'phone' => $this->faker->phoneNumber,
        ];

        $response = $this->post(route('registration.store'), $data);
        $response = $this->post(route('registration.store'), $data);

        $this->assertDatabaseHas('users', [
            'name' => $data['name'],
            'phone' => $data['phone'],
        ]);

        $response->assertStatus(302)
            ->assertRedirectToRoute('registration.index')
            ->assertSessionHasErrors('phone');
    }
}
