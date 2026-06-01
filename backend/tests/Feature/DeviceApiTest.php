<?php

namespace Tests\Feature;

use App\Models\Device;
use App\Models\Ping;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeviceApiTest extends TestCase
{
    use RefreshDatabase;

    // --- POST /api/devices ---

    public function test_creates_device_successfully(): void
    {
        $uuid = fake()->uuid();

        $response = $this->postJson('/api/devices', [
            'uuid' => $uuid,
            'name' => 'Living Room Sensor',
        ]);

        $response->assertCreated()
            ->assertJsonFragment([
                'uuid' => $uuid,
                'name' => 'Living Room Sensor',
            ]);

        $this->assertDatabaseHas('devices', ['uuid' => $uuid, 'name' => 'Living Room Sensor']);
    }

    public function test_create_device_fails_validation_when_uuid_missing(): void
    {
        $this->postJson('/api/devices', ['name' => 'Sensor'])
            ->assertUnprocessable()
            ->assertJsonFragment(['status' => 'error', 'statusCode' => 422]);
    }

    public function test_create_device_fails_validation_when_uuid_invalid(): void
    {
        $this->postJson('/api/devices', ['uuid' => 'not-a-uuid', 'name' => 'Sensor'])
            ->assertUnprocessable()
            ->assertJsonFragment(['status' => 'error', 'statusCode' => 422]);
    }

    public function test_create_device_fails_validation_when_name_missing(): void
    {
        $this->postJson('/api/devices', ['uuid' => fake()->uuid()])
            ->assertUnprocessable()
            ->assertJsonFragment(['status' => 'error', 'statusCode' => 422]);
    }

    // --- POST /api/devices/{uuid}/ping ---

    public function test_stores_ping_for_existing_device(): void
    {
        $device = Device::factory()->create();

        $this->postJson("/api/devices/{$device->uuid}/ping", ['battery_percent' => 75])
            ->assertOk()
            ->assertJson(['data' => ['status' => 'ok']]);

        $this->assertDatabaseHas('pings', [
            'device_id' => $device->id,
            'battery_percent' => 75,
        ]);
    }

    public function test_ping_fails_validation_when_battery_percent_missing(): void
    {
        $device = Device::factory()->create();

        $this->postJson("/api/devices/{$device->uuid}/ping", [])
            ->assertUnprocessable()
            ->assertJsonFragment(['status' => 'error', 'statusCode' => 422]);
    }

    public function test_ping_fails_validation_when_battery_percent_above_max(): void
    {
        $device = Device::factory()->create();

        $this->postJson("/api/devices/{$device->uuid}/ping", ['battery_percent' => 101])
            ->assertUnprocessable()
            ->assertJsonFragment(['status' => 'error', 'statusCode' => 422]);
    }

    public function test_ping_fails_validation_when_battery_percent_below_min(): void
    {
        $device = Device::factory()->create();

        $this->postJson("/api/devices/{$device->uuid}/ping", ['battery_percent' => -1])
            ->assertUnprocessable()
            ->assertJsonFragment(['status' => 'error', 'statusCode' => 422]);
    }

    public function test_ping_returns_404_for_unknown_device(): void
    {
        $this->postJson('/api/devices/' . fake()->uuid() . '/ping', ['battery_percent' => 50])
            ->assertNotFound();
    }

    // --- GET /api/devices/{uuid} ---

    public function test_returns_device_detail(): void
    {
        $device = Device::factory()->create(['name' => 'Kitchen Sensor']);
        Ping::factory()->create(['device_id' => $device->id, 'battery_percent' => 42]);

        $response = $this->getJson("/api/devices/{$device->uuid}");

        $response->assertOk()
            ->assertJsonFragment([
                'uuid' => $device->uuid,
                'name' => 'Kitchen Sensor',
                'last_battery_percenatge' => 42,
            ]);
    }

    public function test_device_detail_returns_404_for_unknown_uuid(): void
    {
        $this->getJson('/api/devices/' . fake()->uuid())
            ->assertNotFound();
    }
}
