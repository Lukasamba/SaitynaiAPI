<?php

use App\Models\Division;
use App\Models\Hall;
use App\Models\Movie;
use App\Models\User;
use App\Models\UserMovie;
use Illuminate\Support\Benchmark;
use Tests\TestCase;

class StressTest extends TestCase
{
    public function testPerformanceAPI(): void
    {
        Benchmark::dd([
            'Scenario Login' => fn() => $this->testLoginSuccess(),
            'Scenario Register' => fn() => $this->testRegisterSuccess(),
            'Scenario Logout' => fn() => $this->testLogoutSuccess(),
            'Scenario Refresh Token' => fn() => $this->testRefreshTokenSuccess(),

            'Scenario Movies List' => fn() => $this->testGetMoviesList(),
            'Scenario Movie Create' => fn() => $this->testCreateMovieSuccess(),
            'Scenario Movie Get' => fn() => $this->testGetMovieSuccess(),
            'Scenario Movie Update' => fn() => $this->testUpdateMovieSuccess(),
            'Scenario Movie Delete' => fn() => $this->testDeleteMovieSuccess(),

            'Scenario Halls List' => fn() => $this->testGetHallsList(),
            'Scenario Hall Create' => fn() => $this->testCreateHallSuccess(),
            'Scenario Hall Get' => fn() => $this->testGetHallSuccess(),
            'Scenario Hall Update' => fn() => $this->testUpdateHallSuccess(),
            'Scenario Hall Delete' => fn() => $this->testDeleteHallSuccess(),

            'Scenario Divisions List' => fn() => $this->testGetDivisionsList(),
            'Scenario Division Create' => fn() => $this->testCreateDivisionSuccess(),
            'Scenario Division Get' => fn() => $this->testGetDivisionSuccess(),
            'Scenario Division Update' => fn() => $this->testUpdateDivisionSuccess(),
            'Scenario Division Delete' => fn() => $this->testDeleteDivisionSuccess(),

            'Scenario Reservations List' => fn() => $this->testGetReservationsList(),
            'Scenario Reserve' => fn() => $this->testReserveMovieSuccess(),
        ]);
    }

    public function testLoginSuccess(): void
    {
        $this->post('api/auth/login', [
            'email' => 'dev@saitynai.com',
            'password' => 'password'
        ]);
    }

    public function testRegisterSuccess(): void
    {
        $newUser = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->email,
            'password' => 'password',
            'password_confirmation' => 'password'
        ];

        $this->post('api/auth/register', $newUser);
    }

    public function testLogoutSuccess(): void
    {
        $user = User::factory()->create();
        $this->login($user);

        $this->post('api/auth/logout');
    }

    public function testRefreshTokenSuccess(): void
    {
        $user = User::factory()->create();
        $this->login($user);

        $this->put('api/auth/refresh');
    }

    public function testGetMoviesList(): void
    {
        $this->get('api/auth/movies');
    }

    public function testCreateMovieSuccess(): void
    {
        $newMovie = [
            'name' => 'movie_name',
            'genre' => 'movie_genre',
            'length' => 'movie_length',
            'image_url' => 'movie_image_url',
        ];

        $this->post('api/movies', $newMovie);
    }

    public function testGetMovieSuccess(): void
    {
        /** @var Movie $movie */
        $movie = Movie::factory()->create();
        $movieId = $movie->getKey();

        $this->get("api/movies/$movieId");
    }

    public function testUpdateMovieSuccess(): void
    {
        /** @var Movie $movie */
        $movie = Movie::factory()->create();
        $movieId = $movie->getKey();

        $newMovie = [
            'name' => 'movie_name',
            'genre' => 'movie_genre',
            'length' => 'movie_length',
            'image_url' => 'movie_image_url',
        ];

        $this->put("api/movies/$movieId", $newMovie);
    }

    public function testDeleteMovieSuccess(): void
    {
        /** @var Movie $movie */
        $movie = Movie::factory()->create();
        $movieId = $movie->getKey();

        $this->delete("api/movies/$movieId");
    }

    public function testGetHallsList(): void
    {
        $this->get('api/halls');
    }

    public function testCreateHallSuccess(): void
    {
        $division = Division::factory()->create();

        $newHall = [
            'division_id' => $division->getKey(),
            'name' => 'hall_name',
            'seats_count' => 5,
        ];

        $this->post('api/halls', $newHall);
    }

    public function testGetHallSuccess(): void
    {
        /** @var Hall $hall */
        $hall = Hall::factory()->create();
        $hallId = $hall->getKey();

        $this->get("api/halls/$hallId");
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

        $this->put("api/halls/$hallId", $newHall);
    }

    public function testDeleteHallSuccess(): void
    {
        /** @var Hall $hall */
        $hall = Hall::factory()->create();
        $hallId = $hall->getKey();

        $this->delete("api/halls/$hallId");
    }

    public function testGetDivisionsList(): void
    {
        $this->get('api/divisions');
    }

    public function testCreateDivisionSuccess(): void
    {
        $newDivision = [
            'address' => 'division_address',
            'halls_count' => 5,
        ];

        $this->post('api/divisions', $newDivision);
    }

    public function testGetDivisionSuccess(): void
    {
        /** @var Division $division */
        $division = Division::factory()->create();
        $divisionId = $division->getKey();

        $this->get("api/divisions/$divisionId");
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

        $this->put("api/divisions/$divisionId", $newDivision);
    }

    public function testDeleteDivisionSuccess(): void
    {
        /** @var Division $division */
        $division = Division::factory()->create();
        $divisionId = $division->getKey();

        $this->delete("api/divisions/$divisionId");
    }

    public function testGetReservationsList(): void
    {
        $user = Auth::user();
        $movie = Movie::factory()->create();

        UserMovie::query()->updateOrCreate([
            'user_id' => $user->getKey(),
            'movie_id' => $movie->getKey(),
        ]);

        $this->get('api/movies/reserve/list');
    }

    public function testReserveMovieSuccess(): void
    {
        $movie = Movie::factory()->create();
        $movieId = $movie->getKey();

        $this->post("api/movies/reserve/$movieId");
    }
}
