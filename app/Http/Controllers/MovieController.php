<?php

namespace App\Http\Controllers;

use App\Http\Requests\Movie\CreateMovieRequest;
use App\Http\Requests\Movie\UpdateMovieRequest;
use App\Http\Responses\Movie\MovieResponse;
use App\Http\Responses\Movie\MoviesTableResponse;
use App\Models\Movie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function getList(): JsonResponse
    {
        $movies = MoviesTableResponse::collection(Movie::all());

        return response()->json($movies);
    }

    public function createMovie(CreateMovieRequest $request): JsonResponse
    {
        $movie = new Movie($request->all());

        $movie->save();

        return response()->json();
    }

    public function getMovie(Movie $movie): JsonResponse
    {
        return response()->json(MovieResponse::from($movie));
    }

    public function updateMovie(UpdateMovieRequest $request, Movie $movie): JsonResponse
    {
        $movie->fill($request->all());

        $movie->save();

        return response()->json(MovieResponse::from($movie));
    }

    public function deleteMovie(): JsonResponse
    {
        return response()->json();
    }
}
