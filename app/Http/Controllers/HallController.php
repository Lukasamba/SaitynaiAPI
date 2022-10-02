<?php

namespace App\Http\Controllers;

use App\Http\Requests\Hall\CreateHallRequest;
use App\Http\Requests\Hall\UpdateHallRequest;
use App\Http\Responses\Hall\HallResponse;
use App\Http\Responses\Hall\HallsTableResponse;
use App\Models\Hall;
use Illuminate\Http\JsonResponse;

class HallController extends Controller
{
    public function getList(): JsonResponse
    {
        $halls = HallsTableResponse::collection(Hall::all());

        return response()->json($halls);
    }

    public function createHall(CreateHallRequest $request): JsonResponse
    {
        $hall = new Hall($request->all());

        $hall->save();

        return response()->json();
    }

    public function getHall(Hall $hall): JsonResponse
    {
        return response()->json(HallResponse::from($hall));
    }

    public function updateHall(UpdateHallRequest $request, Hall $hall): JsonResponse
    {
        $hall->fill($request->all());

        $hall->save();

        return response()->json(HallResponse::from($hall));
    }

    public function deleteHall(Hall $hall): JsonResponse
    {
        $hall->delete();

        return response()->json();
    }
}
