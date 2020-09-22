<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * List User test.
     *
     * @return void
     */
    public function testUserList()
    {
        $response = $this->get('/api/v1/users');
        
        $response->assertStatus(200)
                ->assertJsonPath('data.0', [
                    'id' => 0,
                    'email' => 'parent1@parent.eu',
                    'amount' => '280.00',
                    'currency' => 'EUR',
                    'status' => 'authorised',
                    'registeration' => '2018-11-30',
                    'provider' => 'providerX',
                    'created_at' => '2020-09-22T21:50:40.000000Z',
                    'updated_at' => '2020-09-22T21:50:40.000000Z'
                ]);
    }

    /**
     * List User test.
     *
     * @return void
     */
    public function testUserFilter()
    {
        $response = $this->get('/api/v1/users?provider=providerY');
        
        $response->assertStatus(200)
                ->assertJsonPath('data.0.provider', "providerY");
    }
}
