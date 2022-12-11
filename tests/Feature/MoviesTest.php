<?php

use App\Models\Movie;
use App\Models\User;
use Tests\TestCase;

class MoviesTest extends TestCase
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

        $moviesListUrl = 'api/auth/movies';
        $movieCreateUrl = 'api/movies';
        $movieUrl = "api/movies/$movieId";

        $resList = $this->get($moviesListUrl);
        $resCreate = $this->post($movieCreateUrl);
        $resGet = $this->get($movieUrl);
        $resUpdate = $this->put($movieUrl);
        $resDelete = $this->delete($movieUrl);

        $this->assertTrue($resList->status() !== 404);
        $this->assertTrue($resCreate->status() !== 404);
        $this->assertTrue($resGet->status() !== 404);
        $this->assertTrue($resUpdate->status() !== 404);
        $this->assertTrue($resDelete->status() !== 404);
    }

    public function testGetMoviesList(): void
    {
        $this->get('api/auth/movies')
            ->assertSee('id')
            ->assertSee('name')
            ->assertSee('genre')
            ->assertSee('length')
            ->assertSee('image_url')
            ->assertStatus(200);
    }

    public function testCreateMovieSuccess(): void
    {
        $newMovie = [
            'name' => 'movie_name',
            'genre' => 'movie_genre',
            'length' => 'movie_length',
            'image_url' => 'movie_image_url',
        ];

        $this->post('api/movies', $newMovie)->assertStatus(200);

        /** @var Movie $movie */
        $movie = Movie::query()->where('name', $newMovie['name'])->first();

        $this->assertNotNull($movie);
        $this->assertTrue($movie->name === $newMovie['name']);
    }

    public function testCreateMovieEmptyData(): void
    {
        $newMovie = [
            'name' => '',
            'genre' => '',
            'length' => '',
            'image_url' => '',
        ];

        $this->post('api/movies', $newMovie)->assertStatus(422);
    }

    public function testCreateMovieInvalidData(): void
    {
        $newMovie = [
            'name' => true,
            'genre' => 123,
            'length' => false,
            'image_url' => 321,
        ];

        $this->post('api/movies', $newMovie)->assertStatus(422);

        /** @var Movie $movie */
        $movie = Movie::query()->where('name', $newMovie['name'])->first();

        $this->assertNull($movie);
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

        $this->put("api/movies/$movieId", $newMovie)->assertStatus(200);

        $movie->refresh();

        $this->assertTrue($movie->name === $newMovie['name']);
    }

    public function testUpdateMovieInvalidData(): void
    {
        /** @var Movie $movie */
        $movie = Movie::factory()->create();
        $movieId = $movie->getKey();

        $newMovie = [
            'name' => 'movie_name',
        ];

        $this->put("api/movies/$movieId", $newMovie)->assertStatus(422);

        $movie->refresh();

        $this->assertNotNull($movie);
        $this->assertTrue($movie->name !== $newMovie['name']);
    }

    public function testDeleteMovieSuccess(): void
    {
        /** @var Movie $movie */
        $movie = Movie::factory()->create();
        $movieId = $movie->getKey();

        $this->delete("api/movies/$movieId")->assertStatus(200);

        $deletedMovie = Movie::query()->where('id', $movieId)->first();
        $this->assertNull($deletedMovie);
    }

    public function testDeleteMovieFail(): void
    {
        $this->delete("api/movies/123456789")->assertStatus(404);
    }
}
