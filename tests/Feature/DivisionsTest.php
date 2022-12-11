<?php

use App\Models\Division;
use App\Models\User;
use Tests\TestCase;

class DivisionsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();
        $this->login($user);
    }

    public function testRouteExists(): void
    {
        $divisionId = Division::factory()->create()->getKey();

        $divisionsListUrl = 'api/divisions';
        $divisionCreateUrl = 'api/divisions';
        $divisionUrl = "api/divisions/$divisionId";

        $resList = $this->get($divisionsListUrl);
        $resCreate = $this->post($divisionCreateUrl);
        $resGet = $this->get($divisionUrl);
        $resUpdate = $this->put($divisionUrl);
        $resDelete = $this->delete($divisionUrl);

        $this->assertTrue($resList->status() !== 404);
        $this->assertTrue($resCreate->status() !== 404);
        $this->assertTrue($resGet->status() !== 404);
        $this->assertTrue($resUpdate->status() !== 404);
        $this->assertTrue($resDelete->status() !== 404);
    }

    public function testGetDivisionsList(): void
    {
        $this->get('api/divisions')
            ->assertSee('id')
            ->assertSee('address')
            ->assertSee('halls_count')
            ->assertStatus(200);
    }

    public function testCreateDivisionSuccess(): void
    {
        $newDivision = [
            'address' => 'division_address',
            'halls_count' => 5,
        ];

        $this->post('api/divisions', $newDivision)->assertStatus(200);

        /** @var Division $division */
        $division = Division::query()->where('address', $newDivision['address'])->first();

        $this->assertNotNull($division);
        $this->assertTrue($division->address === $newDivision['address']);
    }

    public function testCreateDivisionEmptyData(): void
    {
        $newDivision = [
            'address' => '',
            'halls_count' => '',
        ];

        $this->post('api/divisions', $newDivision)->assertStatus(422);
    }

    public function testCreateDivisionInvalidData(): void
    {
        $newDivision = [
            'address' => '',
            'halls_count' => '',
        ];

        $this->post('api/divisions', $newDivision)->assertStatus(422);

        /** @var Division $division */
        $division = Division::query()->where('address', $newDivision['address'])->first();

        $this->assertNull($division);
    }

    public function testUpdateDivisionSuccess(): void
    {
        /** @var Division $division */
        $division = Division::factory()->create();
        $divisionId = $division->getKey();

        $newDivision = [
            'address' => 'new_address',
            'halls_count' => 10,
        ];

        $this->put("api/divisions/$divisionId", $newDivision)->assertStatus(200);

        $division->refresh();

        $this->assertTrue($division->address === $newDivision['address']);
    }

    public function testUpdateDivisionInvalidData(): void
    {
        /** @var Division $division */
        $division = Division::factory()->create();
        $divisionId = $division->getKey();

        $newDivision = [
            'address' => 'new_address',
        ];

        $this->put("api/divisions/$divisionId", $newDivision)->assertStatus(422);

        $division->refresh();

        $this->assertNotNull($division);
        $this->assertTrue($division->address !== $newDivision['address']);
    }

    public function testDeleteDivisionSuccess(): void
    {
        /** @var Division $division */
        $division = Division::factory()->create();
        $divisionId = $division->getKey();

        $this->delete("api/divisions/$divisionId")->assertStatus(200);

        $deletedDivision = Division::query()->where('id', $divisionId)->first();
        $this->assertNull($deletedDivision);
    }

    public function testDeleteDivisionFail(): void
    {
        $this->delete("api/divisions/123456789")->assertStatus(404);
    }
}
