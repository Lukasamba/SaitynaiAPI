<?php

use App\Models\Division;
use App\Models\Hall;
use App\Models\User;
use Tests\TestCase;

class HallsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();
        $this->login($user);
    }

    public function testRouteExists(): void
    {
        $hallId = Hall::factory()->create()->getKey();

        $hallsListUrl = 'api/halls';
        $hallCreateUrl = 'api/halls';
        $hallUrl = "api/halls/$hallId";

        $resList = $this->get($hallsListUrl);
        $resCreate = $this->post($hallCreateUrl);
        $resGet = $this->get($hallUrl);
        $resUpdate = $this->put($hallUrl);
        $resDelete = $this->delete($hallUrl);

        $this->assertTrue($resList->status() !== 404);
        $this->assertTrue($resCreate->status() !== 404);
        $this->assertTrue($resGet->status() !== 404);
        $this->assertTrue($resUpdate->status() !== 404);
        $this->assertTrue($resDelete->status() !== 404);
    }

    public function testGetHallsList(): void
    {
        $this->get('api/halls')
            ->assertSee('id')
            ->assertSee('division_id')
            ->assertSee('name')
            ->assertSee('seats_count')
            ->assertStatus(200);
    }

    public function testCreateHallSuccess(): void
    {
        $division = Division::factory()->create();

        $newHall = [
            'division_id' => $division->getKey(),
            'name' => 'hall_name',
            'seats_count' => 5,
        ];

        $this->post('api/halls', $newHall)->assertStatus(200);

        /** @var Hall $hall */
        $hall = Hall::query()->where('name', $newHall['name'])->first();

        $this->assertNotNull($hall);
        $this->assertTrue($hall->name === $newHall['name']);
        $this->assertTrue($hall->division_id === $division->getKey());
    }

    public function testCreateHallEmptyData(): void
    {
        $newHall = [
            'division_id' => 0,
            'name' => '',
            'seats_count' => '',
        ];

        $this->post('api/halls', $newHall)->assertStatus(422);
    }

    public function testCreateHallInvalidData(): void
    {
        $newHall = [
            'division_id' => '',
            'name' => '',
            'seats_count' => '',
        ];

        $this->post('api/halls', $newHall)->assertStatus(422);

        /** @var Hall $hall */
        $hall = Hall::query()->where('name', $newHall['name'])->first();

        $this->assertNull($hall);
    }

    public function testUpdateHallSuccess(): void
    {
        /** @var Hall $hall */
        $hall = Hall::factory()->create();
        $hallId = $hall->getKey();

        $division = Division::factory()->create();
        $newHall = [
            'division_id' => $division->getKey(),
            'name' => 'hall_name',
            'seats_count' => 5,
        ];

        $this->put("api/halls/$hallId", $newHall)->assertStatus(200);

        $hall->refresh();

        $this->assertTrue($hall->name === $newHall['name']);
        $this->assertTrue($hall->division_id === $division->getKey());
    }

    public function testUpdateHallInvalidData(): void
    {
        /** @var Hall $hall */
        $hall = Hall::factory()->create();
        $hallId = $hall->getKey();

        $division = Division::factory()->create();
        $newHall = [
            'name' => '',
        ];

        $this->put("api/halls/$hallId", $newHall)->assertStatus(422);

        $hall->refresh();

        $this->assertNotNull($hall);
        $this->assertTrue($hall->name !== $newHall['name']);
        $this->assertTrue($hall->division_id !== $division->getKey());
    }

    public function testDeleteHallSuccess(): void
    {
        /** @var Hall $hall */
        $hall = Hall::factory()->create();
        $hallId = $hall->getKey();

        $this->delete("api/halls/$hallId")->assertStatus(200);

        $deletedHall = Hall::query()->where('id', $hallId)->first();
        $this->assertNull($deletedHall);
    }

    public function testDeleteHallFail(): void
    {
        $this->delete("api/halls/123456789")->assertStatus(404);
    }
}
