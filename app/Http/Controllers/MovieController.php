<?php

namespace App\Http\Controllers;

use App\Http\Requests\Movie\CreateMovieRequest;
use App\Http\Requests\Movie\UpdateMovieRequest;
use App\Http\Responses\Movie\MovieResponse;
use App\Http\Responses\Movie\MoviesTableResponse;
use App\Http\Responses\Movie\ReservationsTabelResponse;
use App\Models\Movie;
use App\Models\User;
use App\Models\UserMovie;
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

    public function deleteMovie(Movie $movie): JsonResponse
    {
        $movie->delete();

        return response()->json();
    }

    public function getReservationsList(): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        $reservedMovies = UserMovie::query()->where('user_id', $user->getKey())->get();

//
//        Movie::query()->each(function (Movie $movie) use ($reservedMovies, $movies) {
//            foreach ($reservedMovies as $reservedMovie) {
//                if ($movie->id == $reservedMovie->movie_id) {
//                    array_push($movies, $reservedMovie);
//                }
//            }
//        });
//
//
//        dd(json_encode($movies));
//        $movies = ReservationsTabelResponse::collection(Movie::all());



        $movies = [];

        /** @var UserMovie $reservedMovie */
        foreach ($reservedMovies as $reservedMovie) {
            $movie = Movie::query()->where('id', $reservedMovie->movie_id)->first();

            $movies[] = [
                'name' => $movie->getKey(),
                'reservation_date' => $reservedMovie->created_at,
            ];
        }

        return response()->json(ReservationsTabelResponse::collection($movies));
    }

    public function reserveMovie(Movie $movie): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        $userMovie = new UserMovie([
            'user_id' => $user->getKey(),
            'movie_id' => $movie->getKey(),
        ]);

        $userMovie->save();

        return response()->json();
    }
}
