<?php

use App\Models\Movie;
use App\Models\User;
use App\Models\UserMovie;
use Tests\TestCase;

class ReservationsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();
        $this->login($user);
    }

    public function testRouteExists(): void
    {
        $movieId = Movie::factory()->create()->getKey();

        $resList = $this->get('api/movies/reserve/list');
        $resReserve = $this->get("api/movies/reserve/$movieId");

        $this->assertTrue($resList->status() !== 404);
        $this->assertTrue($resReserve->status() !== 404);
    }

    public function testGetReservationsList(): void
    {
        $user = Auth::user();
        $movie = Movie::factory()->create();

        UserMovie::query()->updateOrCreate([
            'user_id' => $user->getKey(),
            'movie_id' => $movie->getKey(),
        ]);

        $this->get('api/movies/reserve/list')
            ->assertSee('name')
            ->assertStatus(200);
    }

    public function testReserveMovieSuccess(): void
    {
        $user = Auth::user();
        $movie = Movie::factory()->create();
        $movieId = $movie->getKey();

        $this->post("api/movies/reserve/$movieId")->assertStatus(200);

        /** @var UserMovie $userMovie */
        $userMovie = UserMovie::query()
            ->where('movie_id', $movieId)
            ->where('user_id', $user->getKey())
            ->first();

        $reservedMovie = Movie::query()->where('id', $userMovie->movie_id)->first();

        $this->assertNotNull($userMovie);
        $this->assertNotNull($reservedMovie);
    }

    public function testReserveMovieFail(): void
    {
        $this->post("api/movies/reserve/123456")->assertStatus(404);
    }
}
